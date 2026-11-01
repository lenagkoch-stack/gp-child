<?php
/**
 * Title: Kiosk: Sperrbildschirm
 * Description: Startseite des Terminals, zusammengesetzt aus Bausteinen: Kopf (Logos, Uhr, Begrüßung), Slider (Rotation mit den Folien), Campus entdecken, Schnellzugriffe und dem Hinweis "Tippe, um loszulegen". Ein Tipp auf eine freie Fläche führt zu /start/. Die Bausteine sind eigene Vorlagen ("Kiosk: Sperrbildschirm – …") und lassen sich einzeln austauschen, weglassen oder umsortieren.
 */
?>
<!-- wp:group {"className":"is-style-tp-lock","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tp-lock"><!-- wp:pattern {"slug":"gp-child/kiosk-sperrbildschirm-kopf"} /-->

<!-- wp:pattern {"slug":"gp-child/kiosk-sperrbildschirm-slider"} /-->

<!-- wp:pattern {"slug":"gp-child/kiosk-sperrbildschirm-entdecken"} /-->

<!-- wp:pattern {"slug":"gp-child/kiosk-sperrbildschirm-navbar"} /-->

<!-- wp:paragraph {"className":"tp-lock__hint"} -->
<p class="tp-lock__hint">Tippe, um loszulegen</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
