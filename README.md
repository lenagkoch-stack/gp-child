# GeneratePress Child – Kiosk-Theme

Theme des Info-Terminals (HS Coburg, 1080 × 1920 px, Hochformat). Stil: Entwurf „Startseite intern“ (weiße Boxen mit Zeilen, runde Ecken, Dunkelblau und Orange).

## Dateien

| Datei | Inhalt |
| --- | --- |
| `kiosk.css` | **Kiosk-Design-System:** Schriften, gemeinsame Variablen `--tp-*`, Typografie, Bausteine. Wird im Frontend und im Editor geladen. |
| `kiosk-editor.css` | Nur im Editor: Boxen ohne feste Höhe, damit man beim Bearbeiten alles sieht. |
| `style.css` | Seitenlayout des Terminals: Bildschirmformat, Platz für die Navigationsleiste, Handy-Seiten (`/checkin/`), Raumplan-Höhe. |
| `kiosk-rotation.js` | Wechselt die Folien einer Rotation (Blockstil „Kiosk: Rotation“). |
| `functions.php` | Lädt Stylesheets und Rotations-Skript, registriert Blockstile und Vorlagen. |
| `block-patterns/` | Vorlagen für den Editor (Kategorie „Kiosk“). |
| `fonts/` | Montserrat (Überschriften) und Nunito (Text). |

## Gemeinsame Variablen

Die `--tp-*`-Variablen in `kiosk.css` gelten für das ganze Terminal. Das Plugin `hsc-kiosk` (Stundenplan, Events) und der Raumplan (`floorplan-widget`) lesen sie direkt; es gibt keine Zuordnung pro Komponente. Beispiele:

- `--tp-color-primary` – Orange für Aktionen und Hervorhebungen
- `--tp-color-on-primary-large` – Schrift auf Orange bei großer, fetter Schrift: hell (`--tp-color-paper`) oder dunkel (`--tp-color-ink`). Kleine Schrift auf Orange nutzt immer `--tp-color-on-primary` (dunkel).
- `--tp-color-band` / `--tp-color-on-band` – Dunkelblau (dunkle Köpfe, Routenplaner, große Buttons, Bedienleiste des Raumplans)
- `--tp-color-tint` (Fuß-Link), `--tp-color-aside` (Zeitfeld), `--tp-color-ground` (Grund), `--tp-color-paper` (Boxen)
- `--tp-slant`, `--tp-radius` / `--tp-radius-s`, `--tp-headline-transform` – Diagonalen (derzeit 0), Ecken, Versalien (derzeit aus)
- `--tp-box-padding`, `--tp-row-padding`, `--tp-card-gap` – Abstände in Box und Zeile
- `--tp-card-aside-factor`, `--tp-card-room-factor`, `--tp-card-action-factor` – Spaltenbreiten (Zeitfeld, Raum, Routenplaner) in Vielfachen der Bedienschrift
- `--tp-icon-*` – Icons (Tabler Icons, MIT) als Masken; `--tp-icon-size`
- `--tp-home-scale`, `--tp-page-gutter`, `--tp-nav-height` – Startseite: Schriftgröße, Rand, frei gehaltener Platz für die Navigationsleiste

Alle Werte stehen in `:root` in `kiosk.css`; zum Verfeinern nach Feedback nur dort ändern.

## Bausteine

| Klasse | Blockstil im Editor | Zweck |
| --- | --- | --- |
| `tp-box` | Gruppe → „Kiosk: Box“ | weiße Box mit fester Höhe (ein Drittel der Startseite); zeigt in der Liste nur ganze Karten |
| `tp-band` (+ `tp-band__kicker`) | Überschrift → „Kiosk: Kopf“ | Kopf einer Box: Icon + Titel, Zusatz (Datum) rechts. Hell (Standard) oder dunkel mit `tp-band--dark`; in „Kiosk: Boxen nebeneinander“ automatisch dunkel |
| `tp-icon--…` | – (Klasse am Kopf) | Icon im Kopf: `route`, `arrow`, `calendar`, `school`, `kitchen`, `message`, `bus`. Im Editor unter *Erweitert → Zusätzliche CSS-Klassen*, z. B. `tp-icon--message` |
| `tp-cards` | Gruppe → „Kiosk: Kartenliste“ | Zeilen mit Trennlinie in einer weißen Fläche; `tp-cards--fit` = nur ganze Karten in der Höhe des Containers; `tp-cards--columns` = feste Spalten, dazu `tp-cards__columns` als Spaltenkopf („Uhrzeit · Veranstaltung · Raum · Dein Weg im Haus“) |
| `tp-card` | Gruppe → „Kiosk: Karte“ | Zeile: `tp-card__aside` (Zeit-/Datumsfeld) · `tp-card__body` (`__title`, `__meta`, `__text`) · `tp-card__room` (Raum) · `tp-card__action` (Button rechts). Ohne Feld (Datumsfeld löschen) z. B. für Hinweise. Varianten: `tp-card--highlight` (Feld orange), `tp-card--muted`. Für Komponenten des Plugins außerdem: `tp-card__aside--date` mit `tp-card__date` (Tag über der Uhrzeit), `tp-card__until` („bis 11:00“), `tp-card__live` („jetzt“ oben im Feld), `tp-card__action--guide` (Button „Routenplaner“, Text in `tp-card__action-label`) |
| `tp-more` | Button → „Kiosk: Fuß-Link“ | heller Button mit Pfeil links unten in der Box; `tp-more__note` = Zusatz, `tp-more--alert` + `tp-more__alert` = dunkle Variante mit Hinweis |
| `tp-columns` | Spalten → „Kiosk: Boxen nebeneinander“ | Boxen in Spalten als eine weiße Fläche mit Trennlinie, Köpfe dunkel (Hinweise, Mensa) |
| `tp-home` | Gruppe → „Kiosk: Startseite“ | Startseite: Boxen teilen sich die Höhe über der Navigationsleiste (`--tp-nav-height` bleibt frei), scrollt nicht. Schrift um `--tp-home-scale` (Standard `1.1`) größer. Ein Kind wächst stärker mit `--tp-home-grow` (Standard `1`). Leere Boxen verschwinden, die übrigen wachsen |
| `tp-status` | – | Statuszeile unter einer Liste („Aktualisiert 12:30 Uhr“), `tp-status--error` = Fehler |
| `tp-sheet` | – | Detailansicht als Bottom-Sheet (`<dialog>`), Optik wie das Raum-Panel im Raumplan: `__panel` › `__header` (`__kicker`, `__title`, `__meta`), `__body` (`__media`, `__text`, `__action`/`__action--guide`), `__footer` (`__qr` mit `__qr-caption`, `__close`). Öffnen und Schließen übernimmt die Komponente; bisher nutzt es `[kiosk_events]` |
| `tp-lock` | Gruppe → „Kiosk: Sperrbildschirm“ | Startseite des Terminals: genau eine Bildschirmhöhe, scrollt nicht, keine Navigationsleiste. Schrift um `--tp-lock-scale` (Standard `2`) größer, Abstände wachsen halb so stark mit. Fuß-Links und Buttons bleiben so groß wie auf den Startseiten (man bedient sie aus der Nähe); die Buttons unten sind so hoch wie die Navigationsleiste (`--tp-nav-height`). Darin oben die Rotation, unten die Buttons. Die Komponenten verhalten sich wie auf den Startseiten: Karte → Detailansicht, Raum-Button → Weg im Raumplan, Fuß-Link → ganze Seite. Karten: schmaleres Zeitfeld, Nebentext so groß wie `--tp-headline-s`; der Raum-Button steht als kleines Schild neben dem Nebentext unter dem Titel, damit der Titel die volle Breite hat |
| `tp-rotation` | Gruppe → „Kiosk: Rotation“ | Jedes direkte Kind ist eine Folie (Box mit Shortcode, eigene „Kiosk: Box mit Karten“, Bild …); sie wechseln alle `--tp-rotation-interval` (Standard `12s`) mit Überblendung, Punkte oben rechts zeigen die Position. Nach einer Berührung und solange eine Detailansicht offen ist, pausiert sie; weiter geht es `--tp-rotation-pause` (Standard `30s`) nach der letzten Berührung bzw. dem Schließen. Eine Box füllt die ganze Rotation. Folien mit `hidden` (Komponente ohne Inhalt, z. B. Mensa am Wochenende) werden übersprungen. Im Editor stehen die Folien untereinander |
| `tp-cta` | Button → „Kiosk: Großer Button“ | großer dunkler Button mit Pfeil; mehrere in einem Buttons-Block teilen sich die Breite und brechen um |

Die Teile einer Karte (`tp-card__aside`, `__body`, `__title`, `__text`) sind CSS-Klassen. Am einfachsten fügt man Karten über die Vorlagen ein, die die Klassen schon gesetzt haben.

## Vorlagen (Editor → Vorlagen → Kiosk)

- **Kiosk: Startseite intern** – Veranstaltungen, darunter Hinweise und Mensa nebeneinander, darunter die Vorlesungen. Für die Seite „Startseite – intern“: Inhalt löschen, Vorlage einfügen (Schritte wie beim Sperrbildschirm unten). Platz für die spätere Navigationsleiste bleibt frei
- **Kiosk: Hinweise** – Box mit dunklem Kopf „Hinweise“ und zwei Hinweisen (Karten ohne Datumsfeld)
- **Kiosk: Box mit Karten** – Box mit Kopf (Icon), zwei Beispielkarten und Fuß-Link
- **Kiosk: Karte** – eine Karte (Datumsfeld, Überschrift, Text), z. B. für einen Hinweis; in eine Kartenliste einfügen
- **Kiosk: Sperrbildschirm** – Mensa, Abfahrten, Stundenplan und Events im Wechsel, darunter je ein Button zu Mensa (`/mensa/`), Abfahrten (`/abfahrten/`), Stundenplan (`/stundenplan/`) und Events (`/events/`) sowie „Neu auf dem Campus“ (`/startseite-gast/`). Für die Seite „Sperrseite“ (Startseite der Website): Inhalt löschen, Vorlage einfügen

### Sperrbildschirm einrichten

1. WP-Admin → *Seiten* → „Sperrseite“ bearbeiten (die Seite ist unter *Einstellungen → Lesen* als Startseite eingestellt).
2. Alten Inhalt entfernen: in den Inhalt klicken, zweimal Cmd/Strg + A, dann Entf.
3. Oben links auf **+** (Block-Inserter) → Reiter **Vorlagen** → Kategorie **Kiosk** → **Kiosk: Sperrbildschirm** anklicken.
4. **Aktualisieren** (bzw. Speichern).
5. Prüfen: die Startseite im Browser öffnen, in den DevTools den Gerätemodus auf 1080 × 1920 stellen. Nach einem Theme-Update einmal hart neu laden (Cmd/Strg + Shift + R).

Im Editor stehen die Folien untereinander; am Terminal wechseln sie. Den Aufbau zeigt die **Listenansicht** (Symbol mit drei Strichen oben links): Sperrbildschirm › Rotation › Boxen, darunter die Buttons.

- **Folie hinzufügen:** in der Listenansicht die Gruppe „Rotation“ wählen und den neuen Block *in* sie einfügen (z. B. Vorlage „Kiosk: Box mit Karten“ für eigene Hinweise, oder eine Gruppe „Kiosk: Box“ mit einem Shortcode-Block). Nur direkte Kinder der Rotation werden zu Folien.
- **Reihenfolge ändern / entfernen:** Box in der Listenansicht verschieben bzw. löschen.
- **Buttons:** Text direkt bearbeiten, Ziel über das Link-Symbol der Werkzeugleiste.
- **Idle-Rückkehr:** Auf jeder Seite außer dem Sperrbildschirm erscheint nach `--tp-idle-timeout` (Standard `90s`) ohne Berührung der Hinweis „Gleich zurück zum Startbildschirm“ mit Countdown `--tp-idle-warning` (Standard `15s`); danach geht es zur Startseite, „Hier bleiben“ bricht ab. `--tp-idle-timeout: 0` schaltet es aus; auf der Handy-Seite Check-in (Raumplan im Modus `mobile`) erscheint es nie (Variablen in `kiosk.css`, Skript `kiosk-idle.js`).
- **Schriftgröße, Standzeit, Pause nach Berührung:** Variablen `--tp-lock-scale`, `--tp-rotation-interval` und `--tp-rotation-pause` in `kiosk.css` (nicht im Editor).

Die Vorlagen liefern nur die Bausteine. Eigene Boxen (z. B. Hinweise) setzt man daraus zusammen; zusätzliche Blöcke in einer Karte, etwa ein Bild, landen in der Inhaltsspalte.

## Was ins Theme gehört, was ins Plugin

Aussehen, das mehrere Komponenten oder Editor-Inhalte teilen (Karten, Bänder, „Jetzt“, Raum-Button, Statuszeile, Sheet), steht hier in `kiosk.css`. Das CSS einer Plugin-Komponente (`hsc-kiosk/assets/*.css`) enthält nur ihr eigenes Layout (Abstände, Modus `compact`) und funktioniert ohne Theme als schlichte Liste. Das Floorplan-Widget gestaltet sich im Shadow DOM selbst und liest nur die `--tp-*`-Variablen.
