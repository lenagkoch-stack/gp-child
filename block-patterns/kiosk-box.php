<?php
/**
 * Title: Kiosk: Box mit Karten
 * Description: Box im Kiosk-Design mit Kopfband, Kartenliste und Fuß-Link, so hoch wie ein Drittel der Startseite. Zeigt nur ganze Karten; weitere Karten mit der Vorlage "Kiosk: Karte" in die Liste einfügen.
 */
?>
<!-- wp:group {"className":"is-style-tp-box","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-box"><!-- wp:heading {"className":"is-style-tp-band"} -->
<h2 class="wp-block-heading is-style-tp-band">Überschrift der Box</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"is-style-tp-cards","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-cards"><!-- wp:group {"className":"is-style-tp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-card"><!-- wp:paragraph {"className":"tp-card__aside"} -->
<p class="tp-card__aside">29.10.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"tp-card__body","layout":{"type":"default"}} -->
<div class="wp-block-group tp-card__body"><!-- wp:heading {"level":3,"className":"tp-card__title"} -->
<h3 class="wp-block-heading tp-card__title">Überschrift</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tp-card__text"} -->
<p class="tp-card__text">Text der Karte</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-tp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-card"><!-- wp:paragraph {"className":"tp-card__aside"} -->
<p class="tp-card__aside">29.10.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"tp-card__body","layout":{"type":"default"}} -->
<div class="wp-block-group tp-card__body"><!-- wp:heading {"level":3,"className":"tp-card__title"} -->
<h3 class="wp-block-heading tp-card__title">Überschrift</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tp-card__text"} -->
<p class="tp-card__text">Text der Karte</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-tp-more"} -->
<div class="wp-block-button is-style-tp-more"><a class="wp-block-button__link wp-element-button">Alle anzeigen</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
