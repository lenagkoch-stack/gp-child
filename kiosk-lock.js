/* Sperrbildschirm (Blockstil "Kiosk: Sperrbildschirm", kiosk.css): ein Tipp auf eine freie Fläche
   führt zur Startseite der Studierenden. Links, Buttons, die Rotation (ihre Karten öffnen die
   Detailansicht) und offene Detailansichten (<dialog>) behalten ihr eigenes Verhalten. */
(function () {
  "use strict";

  const lock = document.querySelector(".tp-lock, .is-style-tp-lock");
  if (!lock || !window.gpKioskLock) return;

  // Begrüßung (Entwickeln): normalerweise aus; ?welcome=1 blendet sie mit dem Text der Vorlage ein,
  // ?welcome=Text mit eigener Überschrift, ?welcome=0 lässt sie aus
  const welcome = lock.querySelector(".tp-lock__welcome");
  const value = (new URLSearchParams(location.search).get("welcome") || "").trim();
  if (welcome && value && !/^(0|off|aus|false)$/i.test(value)) {
    if (value !== "1") welcome.querySelector(".tp-header__title").textContent = value;
    welcome.classList.add("is-shown");
  }

  // Darstellung der Slider-Punkte (Entwickeln): ?dots=a (größere Punkte), c (Icon-Buttons), d (beschriftete Reiter);
  // ohne Parameter bzw. ?dots=b die Segmente mit Füllstand (kiosk.css)
  const dotsVariant = (new URLSearchParams(location.search).get("dots") || "").toLowerCase();
  if (/^[acd]$/.test(dotsVariant)) lock.classList.add("tp-dots--" + dotsVariant);

  // Uhrzeit und Datum zwischen den Logos; die Zeit kommt vom Browser des Terminals, immer in Berliner Zeit.
  // Aktualisiert wird zur vollen Minute
  const clock = lock.querySelector(".tp-lock__clock");
  if (clock) {
    const timeFormat = new Intl.DateTimeFormat("de-DE", { timeZone: "Europe/Berlin", hour: "2-digit", minute: "2-digit", hour12: false });
    const dateFormat = new Intl.DateTimeFormat("de-DE", { timeZone: "Europe/Berlin", weekday: "long", day: "numeric", month: "long" });
    const tick = () => {
      const now = new Date();
      clock.querySelector(".tp-lock__clock-time").textContent = timeFormat.format(now);
      clock.querySelector(".tp-lock__clock-time").setAttribute("datetime", timeFormat.format(now));
      clock.querySelector(".tp-lock__clock-date").textContent = dateFormat.format(now);
      setTimeout(tick, 60000 - (now.getSeconds() * 1000 + now.getMilliseconds()) + 50);
    };
    tick();
  }

  // „3 von 8“ rechts neben dem Titel der Folie, wenn die Liste mehr Einträge hat, als hineinpassen (nur Text, kein Link).
  // Wie die Komponenten zählt es die Karten, die rechts oder unten aus der Liste herausfallen
  function updateCounts() {
    for (const list of lock.querySelectorAll("ul.tp-cards--fit")) {
      const band = list.parentElement.querySelector(":scope > .tp-band");
      if (!band) continue;
      const box = list.getBoundingClientRect();
      const items = [...list.children];
      let shown = 0;
      if (box.width > 0) {
        for (const li of items) {
          const r = li.getBoundingClientRect();
          if (r.width > 0 && r.left < box.right - 1 && r.bottom <= box.bottom + 1) shown++;
        }
      }
      let count = band.querySelector(":scope > .tp-lock__count");
      const text = box.width > 0 && shown > 0 && shown < items.length ? shown + " von " + items.length : "";
      if (!text && !count) continue;
      if (!count) {
        count = document.createElement("span");
        count.className = "tp-lock__count";
        band.append(count);
      }
      if (count.textContent !== text) count.textContent = text;
    }
  }
  let countFrame = 0;
  const scheduleCounts = () => {
    cancelAnimationFrame(countFrame);
    countFrame = requestAnimationFrame(updateCounts);
  };
  new MutationObserver((records) => {
    if (records.some((r) => !r.target.closest || !r.target.closest(".tp-lock__count"))) scheduleCounts();
  }).observe(lock, { childList: true, subtree: true, attributes: true, attributeFilter: ["hidden"] });
  addEventListener("resize", scheduleCounts);
  addEventListener("load", scheduleCounts);
  document.fonts && document.fonts.ready.then(scheduleCounts);
  scheduleCounts();

  lock.addEventListener("click", (event) => {
    if (event.target.closest("a, button, dialog, .tp-rotation, .is-style-tp-rotation")) return;
    location.href = window.gpKioskLock.start;
  });
})();
