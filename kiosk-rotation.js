/* Rotation (Blockstil "Kiosk: Rotation", kiosk.css): zeigt die Kinder der Gruppe nacheinander,
   jedes für --tp-rotation-interval. Folien mit dem Attribut hidden überspringt sie; das setzen
   die Komponenten des Plugins auf ihre Box, wenn sie nichts zu zeigen haben (Mensa am Wochenende).
   Verschwindet die aktive Folie, geht es sofort weiter; bei nur einer Folie steht die Rotation.
   Wer die Rotation berührt oder eine Detailansicht (<dialog>) offen hat, liest gerade: dann
   wechselt sie erst --tp-rotation-pause nach der letzten Berührung bzw. dem Schließen.
   Die Punkte sind Buttons: ein Tipp zeigt die Folie und hält die Rotation für --tp-rotation-pause an.
   Zum Entwickeln: ?slide=2 an der Adresse hält die Rotation auf der 2. Folie (von 1 an gezählt,
   Folien mit hidden mitgezählt) an; ohne gültige Nummer läuft sie wie sonst.
   Zeitsteuerung (Lock): Eine Folie mit data-lock-times="11:30-12:30" (mehrere Zeiträume mit Komma, Ende
   ausgeschlossen) bleibt in diesen Zeiten fest stehen; die Punkte führen weiterhin zu den anderen Folien,
   nach der Pause springt die Rotation zurück. data-lock-hide="13:00-24:00" nimmt eine Folie in diesen Zeiten
   ganz aus der Rotation. data-lock-days="1-5" (Standard; 1 = Mo … 7 = So) legt die Wochentage fest.
   Abschalten: ?lock=off an der Adresse oder data-lock="off" an der Rotation. Zum Testen: ?time=11:45, ?day=3. */
(function () {
  "use strict";

  const DEFAULT_INTERVAL = 12;
  const DEFAULT_PAUSE = 30;
  const POLL = 1000; // während der Pause: so oft prüfen, ob die Detailansicht noch offen ist

  // Folien: direkte Kinder, auch hinter dem inneren Container von GeneratePress
  function slidesOf(root) {
    const inner = root.querySelector(":scope > .wp-block-group__inner-container");
    return [...(inner || root).children].filter((el) => !el.classList.contains("tp-rotation__dots"));
  }

  // Icon (Klasse tp-icon--…) und Titel aus dem Kopf einer Folie, für die Punkte (Varianten C und D in kiosk.css).
  // Der Titel ist nur der Text des Kopfes, ohne Zähler („3 von 5“) und andere Zusätze.
  function slideInfo(slide) {
    const band = slide.querySelector(".tp-band, .is-style-tp-band");
    if (!band) return { icon: "", label: "" };
    const icon = [...band.classList].find((c) => c.startsWith("tp-icon--")) || "";
    const label = [...band.childNodes].filter((n) => n.nodeType === 3).map((n) => n.textContent).join("").trim();
    return { icon, label };
  }

  function ms(root, property, fallback) {
    const seconds = parseFloat(getComputedStyle(root).getPropertyValue(property));
    return (seconds > 0 ? seconds : fallback) * 1000;
  }

  // Zeitsteuerung ----------------------------------------------------------------------------------------------
  const params = new URLSearchParams(location.search);

  // "08:00-09:00,12:30-13:30" -> [[480, 540], [750, 810]] (Minuten seit Mitternacht)
  function parseRanges(text) {
    return String(text || "")
      .split(",")
      .map((part) => part.trim().match(/^(\d{1,2}):(\d{2})\s*-\s*(\d{1,2}):(\d{2})$/))
      .filter(Boolean)
      .map((m) => [Number(m[1]) * 60 + Number(m[2]), Number(m[3]) * 60 + Number(m[4])]);
  }

  // "1-5" oder "1,3,5" -> Tage 1 (Mo) bis 7 (So)
  function parseDays(text) {
    const days = new Set();
    for (const part of String(text || "1-5").split(",")) {
      const m = part.trim().match(/^(\d)(?:\s*-\s*(\d))?$/);
      if (!m) continue;
      for (let d = Number(m[1]); d <= Number(m[2] || m[1]); d++) days.add(d);
    }
    return days;
  }

  // Jetzt: lokale Uhrzeit, zum Testen mit ?time=HH:MM und ?day=1..7 überschrieben
  function clock() {
    const now = new Date();
    let minutes = now.getHours() * 60 + now.getMinutes();
    let day = now.getDay() || 7;
    const t = (params.get("time") || "").match(/^(\d{1,2}):(\d{2})$/);
    if (t) minutes = Number(t[1]) * 60 + Number(t[2]);
    const d = parseInt(params.get("day"), 10);
    if (d >= 1 && d <= 7) day = d;
    return { minutes, day };
  }

  function inRanges(ranges, minutes) {
    return ranges.some(([from, to]) => minutes >= from && minutes < to);
  }

  function start(root) {
    const dots = document.createElement("div");
    dots.className = "tp-rotation__dots";
    dots.setAttribute("role", "group");
    dots.setAttribute("aria-label", "Folien");
    root.append(dots);

    let active = null;
    let timer = 0;
    let touchedAt = 0;
    let locked = false; // die Rotation steht gerade wegen einer Zeitsteuerung auf einer Folie
    const pinned = slidesOf(root)[parseInt(params.get("slide"), 10) - 1] || null;
    const lockEnabled = params.get("lock") !== "off" && root.dataset.lock !== "off";

    // Aus der Rotation genommen: von der Komponente (hidden) oder durch data-lock-hide
    const off = (s) => s.hidden || s.classList.contains("tp-rotation__off");

    // data-lock-hide: Folie in diesen Zeiten ganz ausblenden (Klasse, damit hidden der Komponente unberührt bleibt)
    function applyHide() {
      const { minutes, day } = clock();
      for (const s of slidesOf(root)) {
        const hide = lockEnabled && s.dataset.lockHide && parseDays(s.dataset.lockDays).has(day) && inRanges(parseRanges(s.dataset.lockHide), minutes);
        s.classList.toggle("tp-rotation__off", Boolean(hide));
      }
    }

    // Folie, die jetzt fest stehen soll (data-lock-times), sonst null
    function lockTarget() {
      if (pinned || !lockEnabled) return null;
      const { minutes, day } = clock();
      return slidesOf(root).find((s) => s.dataset.lockTimes && !off(s) && parseDays(s.dataset.lockDays).has(day) && inRanges(parseRanges(s.dataset.lockTimes), minutes)) || null;
    }

    function schedule(delay) {
      if (pinned) return;
      clearTimeout(timer);
      timer = setTimeout(tick, delay);
    }

    function show(slide) {
      active = slide;
      const slides = slidesOf(root);
      for (const s of slides) s.classList.toggle("is-active", s === slide);
      const shown = slides.filter((s) => !off(s));
      dots.replaceChildren(
        ...(shown.length > 1 ? shown : []).map((s, i) => {
          const { icon, label } = slideInfo(s);
          const dot = document.createElement("button");
          dot.type = "button";
          dot.className = "tp-rotation__dot" + (icon ? " " + icon : "") + (s === slide ? " is-active" : "");
          dot.setAttribute("aria-label", "Folie " + (i + 1) + " von " + shown.length + (label ? ": " + label : ""));
          if (s === slide) dot.setAttribute("aria-current", "true");
          dot.append(Object.assign(document.createElement("span"), { className: "tp-rotation__label", textContent: label }));
          dot.addEventListener("click", () => {
            touchedAt = Date.now(); // wie eine Berührung der Rotation: die Folie bleibt --tp-rotation-pause stehen
            hold();
            show(s);
            schedule(POLL);
          });
          return dot;
        })
      );
    }

    // Die Folie steht still (Berührung, Punkt, Detailansicht, ?slide=…): der Füllstand des aktiven Punktes (kiosk.css) bleibt voll
    function hold() {
      root.classList.add("tp-rotation--held");
    }

    // Nächste sichtbare Folie nach der aktiven, am Ende wieder von vorn
    function next() {
      applyHide();
      const target = lockTarget();
      locked = Boolean(target);
      if (target) {
        // Zeitsteuerung: fest auf dieser Folie bleiben, die Zeit wird jede Sekunde geprüft (tick)
        hold();
        show(target);
        schedule(POLL);
        return;
      }
      const slides = slidesOf(root);
      const from = slides.indexOf(active);
      const order = slides.slice(from + 1).concat(slides.slice(0, from + 1));
      root.classList.remove("tp-rotation--held");
      show(order.find((s) => !off(s)) || null);
      schedule(ms(root, "--tp-rotation-interval", DEFAULT_INTERVAL));
    }

    function tick() {
      if (document.querySelector("dialog[open]")) {
        touchedAt = Date.now();
        hold();
      }
      const rest = touchedAt + ms(root, "--tp-rotation-pause", DEFAULT_PAUSE) - Date.now();
      if (rest > 0) schedule(Math.min(rest, POLL));
      else {
        applyHide();
        const target = lockTarget();
        // Bleibt die Zeitsteuerung dieselbe, ist nichts zu tun; sonst (Beginn, Ende, Punkt angetippt) neu entscheiden
        if (locked && target && active === target) schedule(POLL);
        else next();
      }
    }

    if (pinned) {
      hold();
      show(pinned);
    } else next();
    root.classList.add("tp-rotation--ready");
    root.addEventListener("pointerdown", () => {
      touchedAt = Date.now();
      hold();
    });

    // Inhalte der Folien erscheinen erst, wenn die Komponenten geladen sind: dann Icon und Titel der Punkte nachziehen
    let signature = "";
    const sign = () => slidesOf(root).map((s) => Object.values(slideInfo(s)).join("|")).join("#");
    const refresh = new MutationObserver(() => {
      const now = sign();
      if (now !== signature && active) {
        signature = now;
        show(active);
      }
    });
    for (const s of slidesOf(root)) refresh.observe(s, { childList: true, subtree: true });
    signature = sign();

    new MutationObserver(() => (!active || (off(active) && !pinned) ? next() : show(active))).observe(root, {
      attributes: true,
      attributeFilter: ["hidden"],
      subtree: true,
    });
  }

  document.querySelectorAll(".tp-rotation, .is-style-tp-rotation").forEach(start);
})();
