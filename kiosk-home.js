/* Startseite (Blockstil "Kiosk: Startseite", kiosk.css). Mit der Klasse tp-home--fit bekommen Boxen
   mit einer Kartenliste (tp-cards--fit: Events, Vorlesungen) nur so viel Höhe, wie ihre ersten
   Karten brauchen, höchstens MAX_CARDS (2). Den übrigen Platz teilen sich die anderen Boxen (Hinweise,
   Mensa). Ohne die Klasse sind alle Boxen gleich hoch. Das Skript setzt außerdem die Klassen
   der Varianten aus ?home=… (z. B. ?home=fit,scale-90,link-head; ersetzt die Standard-Varianten, ?home=none schaltet sie ab). Reicht der Platz nicht, schrumpfen die Boxen anteilig; die Liste
   zeigt dann weniger ganze Karten. */
(function () {
  "use strict";

  const MAX_CARDS = 2; // Ziel: so viele Karten pro Box; was darüber an Platz bleibt, bekommt die Spaltenreihe

  const home = document.querySelector(".tp-home, .is-style-tp-home");
  if (!home) return;

  // Varianten per Adresse zum Vergleichen: ?home=fit,scale-90,link-head (siehe kiosk.css)
  const variants = new URLSearchParams(location.search).get("home");
  if (variants) {
    // ersetzt die Standard-Varianten aus functions.php
    for (const c of [...home.classList]) if (c.startsWith("tp-home--")) home.classList.remove(c);
    for (const name of variants.split(",")) {
      if (/^[a-z0-9-]+$/.test(name)) home.classList.add("tp-home--" + name);
    }
  }

  let scheduled = false;
  let busy = false;
  let last = "";

  // Boxen: direkte Kinder, auch hinter dem inneren Container von GeneratePress
  function boxes() {
    const inner = home.querySelector(":scope > .wp-block-group__inner-container");
    return [...(inner || home).children];
  }

  function balance() {
    scheduled = false;
    busy = true;
    const items = boxes().filter((box) => !box.hidden && box.querySelector(".tp-cards--fit"));
    for (const box of items) box.style.flex = "";
    if (!home.classList.contains("tp-home--fit")) {
      busy = false;
      return;
    }
    home.offsetHeight; // Layout mit gleich hohen Boxen, daraus die Kartenhöhen messen

    // Höhe jeder Box mit 1 … MAX_CARDS Karten
    const sizes = items.map((box) => {
      const list = box.querySelector(".tp-cards--fit");
      const chrome = box.offsetHeight - list.offsetHeight;
      let sum = chrome + 2; // Spielraum: bei Bruchteilen von Pixeln bräche die letzte Karte sonst in die nächste Spalte um
      return [...list.children]
        .filter((li) => li.offsetHeight > 0)
        .slice(0, MAX_CARDS)
        .map((li) => (sum += li.getBoundingClientRect().height));
    });

    // Platz für die Boxen mit Kartenliste: Startseite ohne Ränder, Abstände und Mindesthöhe der übrigen Boxen
    const style = getComputedStyle(home);
    const visible = boxes().filter((box) => !box.hidden);
    const others = visible.filter((box) => !items.includes(box));
    let available =
      home.clientHeight -
      parseFloat(style.paddingTop) -
      parseFloat(style.paddingBottom) -
      parseFloat(style.rowGap || 0) * (visible.length - 1);
    for (const box of others) available -= parseFloat(getComputedStyle(box).minHeight) || 0;

    // Zu wenig Platz: bei der Box mit den meisten Karten eine Karte weglassen
    const count = sizes.map((s) => s.length);
    const total = () => sizes.reduce((sum, s, i) => sum + (s[count[i] - 1] || 0), 0);
    while (total() > available) {
      const most = Math.max(...count);
      if (most <= 1) break;
      count[count.lastIndexOf(most)]--;
    }

    const flex = sizes.map((s, i) => (count[i] ? `0 0 ${Math.ceil(s[count[i] - 1])}px` : ""));
    items.forEach((box, i) => (box.style.flex = flex[i]));

    // Die Komponenten zählen ihre ausgeblendeten Karten bei resize („37 weitere“)
    const signature = flex.join("|");
    if (signature !== last) {
      last = signature;
      window.dispatchEvent(new Event("resize"));
    }
    busy = false;
  }

  function schedule() {
    if (scheduled || busy) return;
    scheduled = true;
    requestAnimationFrame(balance);
  }

  // Neu rendern die Komponenten (Inhalt, hidden); ihre Link-Texte ändern die Höhe nicht
  new MutationObserver((records) => {
    if (records.some((r) => !r.target.closest || !r.target.closest(".tp-more"))) schedule();
  }).observe(home, { childList: true, subtree: true, attributes: true, attributeFilter: ["hidden"] });

  window.addEventListener("load", schedule);
  document.fonts && document.fonts.ready.then(schedule);
  schedule();
})();
