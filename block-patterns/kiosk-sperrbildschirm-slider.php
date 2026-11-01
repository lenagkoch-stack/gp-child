<?php
/**
 * Title: Kiosk: Sperrbildschirm – Slider
 * Description: Baustein des Sperrbildschirms: die Rotation mit Mensa, ÖPNV, Vorlesungen und Events, dahinter die eigenen Terminal-Folien ([kiosk_folien]). Die Punkte unter dem Slider zeigt kiosk-rotation.js (Darstellung per ?dots=a|b|c|d).
 */
?>
<!-- wp:group {"className":"is-style-tp-rotation","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-rotation"><!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_mensa compact="1" exclude="dessert" max="3" split="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_abfahrten compact="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_stundenplan compact="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_events compact="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[kiosk_folien]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
