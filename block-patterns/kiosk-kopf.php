<?php
/**
 * Title: Kiosk: Seitenkopf
 * Description: Kopf einer Seite: Logos von LCC (links) und Hochschule Coburg (rechts), darunter Kicker, Titel und Untertitel. Texte pro Seite anpassen, Logos lassen sich im Editor austauschen. Steht oben auf der Seite, auch in einer Startseite (Kiosk: Startseite) wächst er nicht mit.
 */
$images = get_stylesheet_directory_uri() . '/images';
?>
<!-- wp:group {"className":"is-style-tp-header","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-header"><!-- wp:group {"className":"tp-header__logos","layout":{"type":"default"}} -->
<div class="wp-block-group tp-header__logos"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tp-header__logo tp-header__logo--lcc"} -->
<figure class="wp-block-image size-full tp-header__logo tp-header__logo--lcc"><img src="<?php echo esc_url( $images . '/logo-lcc.svg' ); ?>" alt="LCC"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tp-header__logo tp-header__logo--hsc"} -->
<figure class="wp-block-image size-full tp-header__logo tp-header__logo--hsc"><img src="<?php echo esc_url( $images . '/logo-hs-coburg.svg' ); ?>" alt="Hochschule Coburg"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"tp-header__kicker"} -->
<p class="tp-header__kicker">Dein Tag am LCC</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"tp-header__title"} -->
<h1 class="wp-block-heading tp-header__title">Unser Campus</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tp-header__subtitle"} -->
<p class="tp-header__subtitle">Termine, Räume und alles für Deinen Tag.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
