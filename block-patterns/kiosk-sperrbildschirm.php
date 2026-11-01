<?php
/**
 * Title: Kiosk: Sperrbildschirm
 * Description: Startseite des Terminals: Logos mit Uhrzeit und Datum dazwischen, Begrüßung (normalerweise aus; per Adresse einblendbar: ?welcome=1 oder ?welcome=Text), darunter Mensa, Abfahrten, Stundenplan und Events im Wechsel in großer Schrift, die Box „Campus entdecken“ (/welcome) und die Schnellzugriffe (dieselben Ziele wie die Navigationsleiste, Shortcode [kiosk_schnellzugriffe]). Ein Tipp auf eine freie Fläche führt zu /start/. Weitere Folien (z. B. eine "Kiosk: Box mit Karten") einfach in die Rotation einfügen.
 */
$images = get_stylesheet_directory_uri() . '/images';
?>
<!-- wp:group {"className":"is-style-tp-lock","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-lock"><!-- wp:group {"className":"tp-header__logos","layout":{"type":"default"}} -->
<div class="wp-block-group tp-header__logos"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tp-header__logo tp-header__logo--lcc"} -->
<figure class="wp-block-image size-full tp-header__logo tp-header__logo--lcc"><img src="<?php echo esc_url( $images . '/logo-lcc.svg' ); ?>" alt="LCC"/></figure>
<!-- /wp:image -->

<!-- wp:html -->
<div class="tp-lock__clock"><time class="tp-lock__clock-time"></time><span class="tp-lock__clock-date"></span></div>
<!-- /wp:html -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tp-header__logo tp-header__logo--hsc"} -->
<figure class="wp-block-image size-full tp-header__logo tp-header__logo--hsc"><img src="<?php echo esc_url( $images . '/logo-hs-coburg.svg' ); ?>" alt="Hochschule Coburg"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tp-lock__welcome","layout":{"type":"default"}} -->
<div class="wp-block-group tp-lock__welcome"><!-- wp:paragraph {"className":"tp-header__kicker"} -->
<p class="tp-header__kicker">Willkommen am LCC</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"tp-header__title"} -->
<h1 class="wp-block-heading tp-header__title">Hi, schön, dass Du da bist.</h1>
<!-- /wp:heading --></div>
<!-- /wp:group -->

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
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:html -->
<a class="tp-lock__discover" href="/welcome"><span class="tp-lock__discover-text"><strong>Campus entdecken</strong><span>Entdecke Mensa, ÖPNV, Vorlesungen, Termine und Ansprechpartner</span></span></a>
<!-- /wp:html -->

<!-- wp:shortcode -->
[kiosk_schnellzugriffe]
<!-- /wp:shortcode -->

<!-- wp:paragraph {"className":"tp-lock__hint"} -->
<p class="tp-lock__hint">Tippe, um loszulegen</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
