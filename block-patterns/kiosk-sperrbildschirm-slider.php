<?php
/**
 * Title: Kiosk: Sperrbildschirm – Slider
 * Description: Baustein des Sperrbildschirms: die Rotation mit Mensa, ÖPNV, Vorlesungen und Events, dahinter die eigenen Terminal-Folien ([kiosk_folien]) und je eine Folie pro Hinweis ([kiosk_hinweise folien="1"], Beiträge der Kategorien Wichtig und Info). Dahinter die Besucher-Folie ([kiosk_besucher]), die während eines Besuchs die Rotation ersetzt. Mensa und Vorlesungen bleiben zu festen Zeiten stehen (data-lock-times, siehe kiosk-rotation.js). Die Punkte unter dem Slider zeigt kiosk-rotation.js (Darstellung per ?dots=a|b|c|d).
 */
?>
<!-- wp:group {"className":"is-style-tp-rotation","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-rotation"><!-- wp:html -->
<!-- <div class="wp-block-group is-style-tp-box" data-lock-times="11:30-12:30" data-lock-hide="13:00-24:00"> -->
<div class="wp-block-group is-style-tp-box" data-lock-times="11:30-12:30">
[kiosk_mensa compact="1" exclude="dessert" max="3" split="1"]
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_abfahrten compact="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="wp-block-group is-style-tp-box" data-lock-times="08:00-09:00,12:30-13:30">
[kiosk_stundenplan compact="1"]
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_events compact="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[kiosk_folien]
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[kiosk_hinweise folien="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[kiosk_besucher]
<!-- /wp:shortcode -->
