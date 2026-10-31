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
<div class="wp-block-group is-style-tp-box"><!-- wp:heading {"className":"is-style-tp-band tp-band--dark tp-icon--message"} -->
<h2 class="wp-block-heading is-style-tp-band tp-band--dark tp-icon--message">Hinweise</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"is-style-tp-cards","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-cards"><!-- wp:group {"className":"is-style-tp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-card"><!-- wp:group {"className":"tp-card__body","layout":{"type":"default"}} -->
<div class="wp-block-group tp-card__body"><!-- wp:heading {"level":3,"className":"tp-card__title"} -->
<h3 class="wp-block-heading tp-card__title">Lernräume länger geöffnet</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tp-card__text"} -->
<p class="tp-card__text">Heute bis 20:00 Uhr für Dich da: Lernbereich im 1. Obergeschoss.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-card"><!-- wp:group {"className":"tp-card__body","layout":{"type":"default"}} -->
<div class="wp-block-group tp-card__body"><!-- wp:heading {"level":3,"className":"tp-card__title"} -->
<h3 class="wp-block-heading tp-card__title">Fundstücke abholen</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tp-card__text"} -->
<p class="tp-card__text">Am Servicepunkt im Erdgeschoss, heute von 09:00 bis 16:00 Uhr.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
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
