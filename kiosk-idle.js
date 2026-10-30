/* Idle-Rückkehr: nach --tp-idle-timeout ohne Berührung erscheint eine Detailansicht (tp-sheet,
   <dialog>) "Gleich zurück zum Startbildschirm" mit Countdown (--tp-idle-warning). Tippt jemand
   "Hier bleiben" (oder irgendwo auf die Ansicht, Esc), läuft die Zeit neu an; sonst geht es
   zurück zum Sperrbildschirm (Startseite). Auf dem Sperrbildschirm selbst tut das Skript nichts.
   --tp-idle-timeout: 0 schaltet die Funktion aus. */
(function () {
  "use strict";

  const DEFAULT_TIMEOUT = 90;
  const DEFAULT_WARNING = 15;
  const TICK = 1000;
  const ACTIVITY = ["pointerdown", "pointermove", "touchstart", "keydown", "wheel"];

  if (document.querySelector(".tp-lock, .is-style-tp-lock")) return;

  // Sekunden aus einer CSS-Variablen; 0 ist gültig (Timeout aus), nur Fehlendes fällt zurück
  function seconds(property, fallback) {
    const value = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(property));
    return value >= 0 ? value : fallback;
  }

  function h(tag, className, text) {
    const el = document.createElement(tag);
    if (className) el.className = className;
    if (text) el.textContent = text;
    return el;
  }

  let lastActivity = Date.now();
  let deadline = 0;
  let dialog = null;
  let countdown = null;

  function leave() {
    for (const d of document.querySelectorAll("dialog[open]")) d.close();
    location.href = "/";
  }

  function stay() {
    if (dialog && dialog.open) dialog.close();
  }

  function build() {
    dialog = h("dialog", "tp-sheet tp-idle");
    dialog.setAttribute("aria-labelledby", "tp-idle-title");
    // Tippen irgendwo auf die Ansicht heißt: ich bin noch da
    dialog.addEventListener("click", stay);
    dialog.addEventListener("close", () => (lastActivity = Date.now()));

    const panel = h("div", "tp-sheet__panel");
    const header = h("header", "tp-sheet__header");
    header.append(h("p", "tp-sheet__kicker", "Inaktivität"));
    const title = h("h2", "tp-sheet__title", "Gleich zurück zum Startbildschirm");
    title.id = "tp-idle-title";
    header.append(title);
    panel.append(header);

    const body = h("div", "tp-sheet__body");
    countdown = h("p", "tp-sheet__text tp-idle__countdown");
    body.append(countdown);
    panel.append(body);

    const footer = h("footer", "tp-sheet__footer");
    const close = h("button", "tp-sheet__close", "Hier bleiben");
    close.type = "button";
    footer.append(close);
    panel.append(footer);

    dialog.append(panel);
    document.body.append(dialog);
  }

  function warn(warning) {
    if (!dialog) build();
    deadline = Date.now() + warning * 1000;
    update();
    dialog.showModal();
    dialog.querySelector(".tp-sheet__close").focus();
  }

  function update() {
    const rest = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
    countdown.textContent = `Es geht zurück in ${rest} ${rest === 1 ? "Sekunde" : "Sekunden"}.`;
  }

  function tick() {
    if (dialog && dialog.open) {
      if (Date.now() >= deadline) leave();
      else update();
      return;
    }
    const timeout = seconds("--tp-idle-timeout", DEFAULT_TIMEOUT);
    if (timeout > 0 && Date.now() - lastActivity >= timeout * 1000) {
      warn(seconds("--tp-idle-warning", DEFAULT_WARNING));
    }
  }

  for (const type of ACTIVITY) {
    addEventListener(
      type,
      () => {
        if (!(dialog && dialog.open)) lastActivity = Date.now();
      },
      { passive: true, capture: true }
    );
  }
  setInterval(tick, TICK);
})();
