<?php
/**
 * Title: Kiosk: Startseite intern
 * Description: Startseite für Studierende und Mitarbeitende: Veranstaltungen, daneben Hinweise und Mensa, darunter die Vorlesungen. Füllt den Bildschirm über der Navigationsleiste; leere Boxen (z. B. keine Vorlesungen mehr) verschwinden, die übrigen wachsen.
 */
?>
<!-- wp:group {"className":"is-style-tp-home","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-home"><!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_events compact="1" more_url="/events/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"is-style-tp-columns"} -->
<div class="wp-block-columns is-style-tp-columns"><!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_hinweise compact="1" more_url="/hinweise/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_mensa compact="1" size="small" more_url="/mensa/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:shortcode -->
[kiosk_stundenplan compact="1" more_url="/stundenplan/"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
