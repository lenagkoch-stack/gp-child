/* Uhrzeit und Datum zwischen den Logos des Seitenkopfs (.tp-header__logos). Steht die Uhr nicht in der
   Seite (alle Seiten außer dem Sperrbildschirm), setzt das Skript sie zwischen die Logos; die Logos werden
   dann klein wie am Sperrbildschirm (.tp-header__logos--clock in kiosk.css). Die Zeit kommt vom Browser
   des Terminals, immer in Berliner Zeit. Aktualisiert wird zur vollen Minute. Handy-Seiten laden das Skript nicht. */
(function () {
  "use strict";

  const headers = document.querySelectorAll(".tp-header__logos");
  if (!headers.length) return;

  const clocks = [];
  for (const logos of headers) {
    let clock = logos.querySelector(".tp-lock__clock");
    if (!clock) {
      clock = document.createElement("div");
      clock.className = "tp-lock__clock";
      clock.innerHTML = '<time class="tp-lock__clock-time"></time><span class="tp-lock__clock-date"></span>';
      const container = logos.querySelector(":scope > .wp-block-group__inner-container") || logos;
      const hsc = container.querySelector(".tp-header__logo--hsc");
      container.insertBefore(clock, hsc || null);
    }
    logos.classList.add("tp-header__logos--clock");
    clocks.push(clock);
  }

  const timeFormat = new Intl.DateTimeFormat("de-DE", { timeZone: "Europe/Berlin", hour: "2-digit", minute: "2-digit", hour12: false });
  const dateFormat = new Intl.DateTimeFormat("de-DE", { timeZone: "Europe/Berlin", weekday: "long", day: "numeric", month: "long" });
  const tick = () => {
    const now = new Date();
    const time = timeFormat.format(now);
    const date = dateFormat.format(now);
    for (const clock of clocks) {
      const t = clock.querySelector(".tp-lock__clock-time");
      t.textContent = time;
      t.setAttribute("datetime", time);
      clock.querySelector(".tp-lock__clock-date").textContent = date;
    }
    setTimeout(tick, 60000 - (now.getSeconds() * 1000 + now.getMilliseconds()) + 50);
  };
  tick();
})();
