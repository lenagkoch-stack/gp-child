/* Rotation (Blockstil "Kiosk: Rotation", kiosk.css): zeigt die Kinder der Gruppe nacheinander,
   jedes für --tp-rotation-interval. Folien mit dem Attribut hidden überspringt sie; das setzen
   die Komponenten des Plugins auf ihre Box, wenn sie nichts zu zeigen haben (Mensa am Wochenende).
   Verschwindet die aktive Folie, geht es sofort weiter; bei nur einer Folie steht die Rotation.
   Wer die Rotation berührt oder eine Detailansicht (<dialog>) offen hat, liest gerade: dann
   wechselt sie erst --tp-rotation-pause nach der letzten Berührung bzw. dem Schließen.
   Die Punkte sind Buttons: ein Tipp zeigt die Folie und hält die Rotation für --tp-rotation-pause an.
   Zum Entwickeln: ?slide=2 an der Adresse hält die Rotation auf der 2. Folie (von 1 an gezählt,
   Folien mit hidden mitgezählt) an; ohne gültige Nummer läuft sie wie sonst. */
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

  function start(root) {
    const dots = document.createElement("div");
    dots.className = "tp-rotation__dots";
    dots.setAttribute("role", "group");
    dots.setAttribute("aria-label", "Folien");
    root.append(dots);

    let active = null;
    let timer = 0;
    let touchedAt = 0;
    const pinned = slidesOf(root)[parseInt(new URLSearchParams(location.search).get("slide"), 10) - 1] || null;

    function schedule(delay) {
      if (pinned) return;
      clearTimeout(timer);
      timer = setTimeout(tick, delay);
    }

    function show(slide) {
      active = slide;
      const slides = slidesOf(root);
      for (const s of slides) s.classList.toggle("is-active", s === slide);
      const shown = slides.filter((s) => !s.hidden);
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
      const slides = slidesOf(root);
      const from = slides.indexOf(active);
      const order = slides.slice(from + 1).concat(slides.slice(0, from + 1));
      root.classList.remove("tp-rotation--held");
      show(order.find((s) => !s.hidden) || null);
      schedule(ms(root, "--tp-rotation-interval", DEFAULT_INTERVAL));
    }

    function tick() {
      if (document.querySelector("dialog[open]")) {
        touchedAt = Date.now();
        hold();
      }
      const rest = touchedAt + ms(root, "--tp-rotation-pause", DEFAULT_PAUSE) - Date.now();
      if (rest > 0) schedule(Math.min(rest, POLL));
      else next();
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

    new MutationObserver(() => (!active || (active.hidden && !pinned) ? next() : show(active))).observe(root, {
      attributes: true,
      attributeFilter: ["hidden"],
      subtree: true,
    });
  }

  document.querySelectorAll(".tp-rotation, .is-style-tp-rotation").forEach(start);
})();
