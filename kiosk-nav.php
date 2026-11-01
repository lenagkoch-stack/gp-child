<?php
/**
 * Navigationsleiste: steht unten auf jeder Seite des Terminals, außer auf dem Sperrbildschirm
 * (Startseite der Website) und den Handy-Seiten. Aussehen: .tp-nav in kiosk.css.
 * Die Ziele stehen nur hier in der Liste; Reihenfolge = Reihenfolge in der Leiste (4 pro Reihe).
 * "\u{00AD}" ist ein weicher Trennstrich, damit lange Wörter umbrechen können.
 * Vierter Eintrag: englische Beschriftung (data-en); der Umschalter (hsc-kiosk: kiosk-lang.js)
 * tauscht sie gegen den deutschen Text. Gleiches Muster für andere feste Texte im Theme.
 */

// Ziel von "Start": die Startseite der Studierenden (nicht der Sperrbildschirm)
const GP_CHILD_KIOSK_START = '/start/';

function gp_child_kiosk_nav_items() {
    return array(
        array( '/stundenplan/',    'Vorlesungen',                    'school',   'Lectures' ),
        array( '/events/',         'Events',                           'calendar', 'Events' ),
        array( '/mensa/',          'Mensa',                          'kitchen',  'Canteen' ),
        array( '/abfahrten/',      'ÖPNV',                           'bus',      'Transit' ),
        array( '/raumplan/',       'Raumfinder',                     'map',      'Room finder' ),
        array( '/hinweise/',       'Hinweise',                       'message',  'Notices' ),
        array( '/ansprechpartner/', "Ansprech\u{00AD}partner",       'users',    'Contacts' ),
        array( '/fehler-melden/',  'Fehler melden',                  'alert',    'Report a problem' ),
    );
}

add_action( 'wp_footer', function() {
    if ( is_front_page() || is_admin() ) {
        return;
    }
    // Handy-Seiten (QR-Ziel, Raumplan im Modus "mobile") haben keine Leiste
    $post = get_post();
    if ( $post && false !== strpos( $post->post_content, 'mode="mobile"' ) ) {
        return;
    }

    $current = untrailingslashit( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ) );
    ?>
<nav class="tp-nav" aria-label="Hauptnavigation">
    <div class="tp-nav__top">
        <a class="tp-nav__back" href="<?php echo esc_url( GP_CHILD_KIOSK_START ); ?>">
            <span class="tp-nav__icon tp-icon--home" aria-hidden="true"></span>Start
        </a>
        <div class="tp-nav__langs" role="group" aria-label="Sprache">
            <button type="button" class="tp-nav__lang" lang="de" data-lang="de" aria-pressed="true">Deutsch</button>
            <button type="button" class="tp-nav__lang" lang="en" data-lang="en" aria-pressed="false">English</button>
        </div>
    </div>
    <div class="tp-nav__targets">
        <?php foreach ( gp_child_kiosk_nav_items() as list( $href, $label, $icon, $label_en ) ) : ?>
            <a class="tp-nav__target" href="<?php echo esc_url( $href ); ?>"<?php echo untrailingslashit( $href ) === $current ? ' aria-current="page"' : ''; ?>>
                <span class="tp-nav__icon tp-icon--<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
                <span data-en="<?php echo esc_attr( $label_en ); ?>"><?php echo esc_html( $label ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
    <?php
} );

/*
 * Schnellzugriffe auf dem Sperrbildschirm: dieselben Ziele wie die Navigationsleiste (ohne Start und
 * Sprache), damit die Liste nur an einer Stelle gepflegt wird. Einbinden mit [kiosk_schnellzugriffe].
 * Aussehen: .tp-lock__quick in kiosk.css.
 */
add_shortcode( 'kiosk_schnellzugriffe', function() {
    ob_start();
    ?>
<section class="tp-lock__quick" aria-label="Schnellzugriffe">
    <h2 class="tp-lock__quick-title">Schnellzugriffe</h2>
    <div class="tp-lock__quick-grid">
        <?php foreach ( gp_child_kiosk_nav_items() as list( $href, $label, $icon, $label_en ) ) : ?>
            <a class="tp-lock__quick-tile" href="<?php echo esc_url( $href ); ?>">
                <span class="tp-nav__icon tp-icon--<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
                <span data-en="<?php echo esc_attr( $label_en ); ?>"><?php echo esc_html( $label ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
    <?php
    return ob_get_clean();
} );
