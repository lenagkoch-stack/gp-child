<?php
/**
 * Navigationsleiste: steht unten auf jeder Seite des Terminals, außer auf dem Sperrbildschirm
 * (Startseite der Website) und den Handy-Seiten. Aussehen: .tp-nav in kiosk.css.
 * Die Ziele stehen nur hier in der Liste; Reihenfolge = Reihenfolge in der Leiste (4 pro Reihe).
 * "\u{00AD}" ist ein weicher Trennstrich, damit lange Wörter umbrechen können.
 */

// Ziel von "Start": die Startseite der Studierenden (nicht der Sperrbildschirm)
const GP_CHILD_KIOSK_START = '/start/';

function gp_child_kiosk_nav_items() {
    return array(
        array( '/stundenplan/',    'Vorlesungen',                    'school' ),
        array( '/events/',         'Events',                           'calendar' ),
        array( '/mensa/',          'Mensa',                          'kitchen' ),
        array( '/abfahrten/',      'ÖPNV',                           'bus' ),
        array( '/raumplan/',       'Raumfinder',                     'map' ),
        array( '/hinweise/',       'Hinweise',                       'message' ),
        array( '/ansprechpartner/', "Ansprech\u{00AD}partner",       'users' ),
        array( '/fehler-melden/',  'Fehler melden',                  'alert' ),
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
        <?php foreach ( gp_child_kiosk_nav_items() as list( $href, $label, $icon ) ) : ?>
            <a class="tp-nav__target" href="<?php echo esc_url( $href ); ?>"<?php echo untrailingslashit( $href ) === $current ? ' aria-current="page"' : ''; ?>>
                <span class="tp-nav__icon tp-icon--<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
                <span><?php echo esc_html( $label ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
    <?php
} );
