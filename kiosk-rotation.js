/* Rotation (Blockstil "Kiosk: Rotation", kiosk.css): zeigt die Kinder der Gruppe nacheinander,
   jedes für --tp-rotation-interval. Folien mit dem Attribut hidden überspringt sie; das setzen
   die Komponenten des Plugins auf ihre Box, wenn sie nichts zu zeigen haben (Mensa am Wochenende).
   Verschwindet die aktive Folie, geht es sofort weiter; bei nur einer Folie steht die Rotation.
   Wer die Rotation berührt oder eine Detailansicht (<dialog>) offen hat, liest gerade: dann
   wechselt sie erst --tp-rotation-pause nach der letzten Berührung bzw. dem Schließen. */
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

  function ms(root, property, fallback) {
    const seconds = parseFloat(getComputedStyle(root).getPropertyValue(property));
    return (seconds > 0 ? seconds : fallback) * 1000;
  }

  function start(root) {
    const dots = document.createElement("div");
    dots.className = "tp-rotation__dots";
    dots.setAttribute("aria-hidden", "true");
    root.append(dots);

    let active = null;
    let timer = 0;
    let touchedAt = 0;

    function schedule(delay) {
      clearTimeout(timer);
      timer = setTimeout(tick, delay);
    }

    function show(slide) {
      active = slide;
      const slides = slidesOf(root);
      for (const s of slides) s.classList.toggle("is-active", s === slide);
      const shown = slides.filter((s) => !s.hidden);
      dots.replaceChildren(
        ...(shown.length > 1 ? shown : []).map((s) => {
          const dot = document.createElement("span");
          dot.className = "tp-rotation__dot" + (s === slide ? " is-active" : "");
          return dot;
        })
      );
    }

    // Nächste sichtbare Folie nach der aktiven, am Ende wieder von vorn
    function next() {
      const slides = slidesOf(root);
      const from = slides.indexOf(active);
      const order = slides.slice(from + 1).concat(slides.slice(0, from + 1));
      show(order.find((s) => !s.hidden) || null);
      schedule(ms(root, "--tp-rotation-interval", DEFAULT_INTERVAL));
    }

    function tick() {
      if (document.querySelector("dialog[open]")) touchedAt = Date.now();
      const rest = touchedAt + ms(root, "--tp-rotation-pause", DEFAULT_PAUSE) - Date.now();
      if (rest > 0) schedule(Math.min(rest, POLL));
      else next();
    }

    next();
    root.classList.add("tp-rotation--ready");
    root.addEventListener("pointerdown", () => (touchedAt = Date.now()));

    new MutationObserver(() => (!active || active.hidden ? next() : show(active))).observe(root, {
      attributes: true,
      attributeFilter: ["hidden"],
      subtree: true,
    });
  }

  document.querySelectorAll(".tp-rotation, .is-style-tp-rotation").forEach(start);
})();
