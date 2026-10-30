<?php
/**
 * Title: Kiosk: Sperrbildschirm
 * Description: Startseite des Terminals: Mensa, Abfahrten, Stundenplan und Events im Wechsel, in großer Schrift, darunter zwei Buttons zu den Startseiten. Weitere Folien (z. B. eine "Kiosk: Box mit Karten") einfach in die Rotation einfügen.
 */
?>
<!-- wp:group {"className":"is-style-tp-lock","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-lock"><!-- wp:group {"className":"is-style-tp-rotation","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-rotation"><!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_mensa compact="1" more_url="/mensa/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_abfahrten compact="1" more_url="/abfahrten/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_stundenplan compact="1" more_url="/stundenplan/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_events compact="1" more_url="/events/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-tp-cta"} -->
<div class="wp-block-button is-style-tp-cta"><a class="wp-block-button__link wp-element-button" href="/startseite-intern/">Ich kenne mich aus</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-tp-cta"} -->
<div class="wp-block-button is-style-tp-cta"><a class="wp-block-button__link wp-element-button" href="/startseite-gast/">Neu auf dem Campus</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
