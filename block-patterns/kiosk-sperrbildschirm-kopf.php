<?php
/**
 * Title: Kiosk: Sperrbildschirm – Kopf
 * Description: Baustein des Sperrbildschirms: Logos von LCC und Hochschule Coburg mit Uhrzeit und Datum dazwischen (kiosk-lock.js), darunter die Begrüßung, die normalerweise ausgeblendet ist (per Adresse einblendbar: ?welcome=1 oder ?welcome=Text). Steht in der Gruppe "Kiosk: Sperrbildschirm" ganz oben.
 */
$images = get_stylesheet_directory_uri() . '/images';
?>
<!-- wp:group {"className":"tp-header__logos","layout":{"type":"default"}} -->
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
