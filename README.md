# GeneratePress Child – Kiosk-Theme

Theme des Info-Terminals (HS Coburg, 1080 × 1920 px, Hochformat). Stil: lucas-cranach-campus.de.

## Dateien

| Datei | Inhalt |
| --- | --- |
| `kiosk.css` | **Kiosk-Design-System:** Schriften, gemeinsame Variablen `--tp-*`, Typografie, Bausteine. Wird im Frontend und im Editor geladen. |
| `kiosk-editor.css` | Nur im Editor: Boxen ohne feste Höhe, damit man beim Bearbeiten alles sieht. |
| `style.css` | Seitenlayout des Terminals: Bildschirmformat, Platz für die Navigationsleiste, Handy-Seiten (`/checkin/`), Raumplan-Höhe. |
| `functions.php` | Lädt die Stylesheets, registriert Blockstile und Vorlagen. |
| `block-patterns/` | Vorlagen für den Editor (Kategorie „Kiosk“). |
| `fonts/` | Montserrat (Überschriften) und Nunito (Text). |

## Gemeinsame Variablen

Die `--tp-*`-Variablen in `kiosk.css` gelten für das ganze Terminal. Das Plugin `hsc-kiosk` (Stundenplan, Events) und der Raumplan (`floorplan-widget`) lesen sie direkt; es gibt keine Zuordnung pro Komponente. Beispiele:

- `--tp-color-primary` – Orange für Aktionen und Hervorhebungen
- `--tp-color-on-primary-large` – Schrift auf Orange bei großer, fetter Schrift: hell (`--tp-color-paper`) oder dunkel (`--tp-color-ink`). Kleine Schrift auf Orange nutzt immer `--tp-color-on-primary` (dunkel).
- `--tp-color-band` / `--tp-color-on-band` – dunkle Bänder (Kopfband, Bedienleiste, Raum-Button)
- `--tp-slant`, `--tp-radius`, `--tp-headline-transform` – Diagonalen, Ecken, Versalien

## Bausteine

| Klasse | Blockstil im Editor | Zweck |
| --- | --- | --- |
| `tp-box` | Gruppe → „Kiosk: Box“ | Rahmen mit fester Höhe (ein Drittel der Startseite); zeigt in der Liste nur ganze Karten |
| `tp-band` (+ `tp-band__kicker`) | Überschrift → „Kiosk: Kopfband“ | dunkles Kopfband, optional mit Unterzeile darüber |
| `tp-cards` | Gruppe → „Kiosk: Kartenliste“ | Liste von Karten; `tp-cards--fit` = nur ganze Karten in der Höhe des Containers |
| `tp-card` | Gruppe → „Kiosk: Karte“ | Karte: `tp-card__aside` (Zeit-/Datumsfeld) · `tp-card__body` (`__title`, `__meta`, `__text`) · `tp-card__action` (Button rechts). Varianten: `tp-card--highlight` (Feld orange), `tp-card--muted`. Für Komponenten des Plugins außerdem: `tp-card__aside--date` mit `tp-card__date` (Tag über der Uhrzeit), `tp-card__live` („Jetzt“ mit Pulspunkt unten im Feld), `tp-card__action--guide` (Raum-Button mit Wegweiser) |
| `tp-more` | Button → „Kiosk: Fuß-Link“ | Fuß-Link mit Pfeil; `tp-more__note` = Zusatz, `tp-more--alert` + `tp-more__alert` = dunkle Variante mit Hinweis |
| `tp-status` | – | Statuszeile unter einer Liste („Aktualisiert 12:30 Uhr“), `tp-status--error` = Fehler |
| `tp-sheet` | – | Detailansicht als Bottom-Sheet (`<dialog>`), Optik wie das Raum-Panel im Raumplan: `__panel` › `__header` (`__kicker`, `__title`, `__meta`), `__body` (`__media`, `__text`, `__action`/`__action--guide`), `__footer` (`__qr` mit `__qr-caption`, `__close`). Öffnen und Schließen übernimmt die Komponente; bisher nutzt es `[kiosk_events]` |

Die Teile einer Karte (`tp-card__aside`, `__body`, `__title`, `__text`) sind CSS-Klassen. Am einfachsten fügt man Karten über die Vorlagen ein, die die Klassen schon gesetzt haben.

## Vorlagen (Editor → Vorlagen → Kiosk)

- **Kiosk: Box mit Karten** – Box mit Kopfband, zwei Beispielkarten und Fuß-Link
- **Kiosk: Karte** – eine Karte (Datumsfeld, Überschrift, Text), z. B. für einen Hinweis; in eine Kartenliste einfügen

Die Vorlagen liefern nur die Bausteine. Eigene Boxen (z. B. Hinweise) setzt man daraus zusammen; zusätzliche Blöcke in einer Karte, etwa ein Bild, landen in der Inhaltsspalte.

## Was ins Theme gehört, was ins Plugin

Aussehen, das mehrere Komponenten oder Editor-Inhalte teilen (Karten, Bänder, „Jetzt“, Raum-Button, Statuszeile, Sheet), steht hier in `kiosk.css`. Das CSS einer Plugin-Komponente (`hsc-kiosk/assets/*.css`) enthält nur ihr eigenes Layout (Abstände, Modus `compact`) und funktioniert ohne Theme als schlichte Liste. Das Floorplan-Widget gestaltet sich im Shadow DOM selbst und liest nur die `--tp-*`-Variablen.
