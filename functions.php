<?php

/*
 * Standard-Varianten der Startseite (Gruppe "Kiosk: Startseite", siehe kiosk.css, kiosk-home.js):
 * fit = Boxen nach Inhalt, link-head = Fuß-Link in der Kopfzeile, dark-head = alle Köpfe dunkelblau. Weitere: scale-90.
 * Mit ?home=… an der Adresse ersetzt man sie zum Vergleichen (?home=none = keine).
 */
const GP_CHILD_HOME_DEFAULTS = array( 'fit', 'link-head', 'dark-head' );

add_filter( 'render_block_core/group', function( $content, $block ) {
    $classes = $block['attrs']['className'] ?? '';
    if ( ! preg_match( '/(^|\s)(is-style-)?tp-home(\s|$)/', $classes ) ) {
        return $content;
    }
    $add = implode( ' ', array_map( fn( $name ) => 'tp-home--' . $name, GP_CHILD_HOME_DEFAULTS ) );
    return preg_replace( '/(<div class="[^"]*)"/', '$1 ' . $add . '"', $content, 1 );
}, 10, 2 );

add_action( 'wp_enqueue_scripts', function() {

    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css'
    );

    // Kiosk-Design-System: Schriften, --tp-* Variablen, Bausteine (auch vom Plugin hsc-kiosk genutzt)
    wp_enqueue_style(
        'gp-child-kiosk',
        get_stylesheet_directory_uri() . '/kiosk.css',
        array( 'generatepress-style', 'generate-style' ), // nach GeneratePress, damit die Bausteine gewinnen
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'generatepress-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'gp-child-kiosk' ),
        wp_get_theme()->get('Version')
    );

    // Rotation (Blockstil "Kiosk: Rotation"); ohne Rotation auf der Seite tut das Skript nichts
    wp_enqueue_script(
        'gp-child-kiosk-rotation',
        get_stylesheet_directory_uri() . '/kiosk-rotation.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Startseite: Boxen mit Kartenliste nur so hoch wie ihre ersten Karten, der Rest geht an die übrigen
    wp_enqueue_script(
        'gp-child-kiosk-home',
        get_stylesheet_directory_uri() . '/kiosk-home.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Idle-Rückkehr: nach Inaktivität Hinweis, dann zurück zum Sperrbildschirm (nicht auf diesem selbst)
    wp_enqueue_script(
        'gp-child-kiosk-idle',
        get_stylesheet_directory_uri() . '/kiosk-idle.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Sperrbildschirm: Tipp auf eine freie Fläche führt zur Startseite der Studierenden
    if ( is_front_page() ) {
        wp_enqueue_script(
            'gp-child-kiosk-lock',
            get_stylesheet_directory_uri() . '/kiosk-lock.js',
            array(),
            wp_get_theme()->get('Version'),
            true
        );
        wp_localize_script( 'gp-child-kiosk-lock', 'gpKioskLock', array( 'start' => GP_CHILD_KIOSK_START ) );
    }

});

// Navigationsleiste unten auf jeder Seite außer Sperrbildschirm und Handy-Seiten
require_once get_stylesheet_directory() . '/kiosk-nav.php';

/*
 * Editor: dieselben Bausteine wie im Frontend, damit Inhalte beim Bearbeiten so
 * aussehen wie am Terminal. kiosk-editor.css hebt nur die feste Boxhöhe auf.
 */
add_action( 'after_setup_theme', function() {
    add_theme_support( 'editor-styles' );
    add_editor_style( array( 'kiosk.css', 'kiosk-editor.css' ) );
} );

/*
 * Bausteine als Blockstile (im Editor unter "Stile" wählbar) und als Vorlagen
 * (Kategorie "Kiosk", Dateien in block-patterns/). Die Teile einer Karte
 * (tp-card__aside, __body, __title, __text) sind CSS-Klassen, die die Vorlagen setzen.
 */
add_action( 'init', function() {
    $styles = array(
        'core/group'   => array(
            'tp-box'   => 'Kiosk: Box',
            'tp-cards' => 'Kiosk: Kartenliste',
            'tp-card'  => 'Kiosk: Karte',
            'tp-home'     => 'Kiosk: Startseite',
            'tp-lock'     => 'Kiosk: Sperrbildschirm',
            'tp-rotation' => 'Kiosk: Rotation',
            'tp-header'   => 'Kiosk: Seitenkopf',
        ),
        'core/heading' => array( 'tp-band' => 'Kiosk: Kopf' ),
        'core/columns' => array( 'tp-columns' => 'Kiosk: Boxen nebeneinander' ),
        'core/button'  => array(
            'tp-more' => 'Kiosk: Fuß-Link',
            'tp-cta'  => 'Kiosk: Großer Button',
        ),
    );
    foreach ( $styles as $block => $list ) {
        foreach ( $list as $name => $label ) {
            register_block_style( $block, array( 'name' => $name, 'label' => $label ) );
        }
    }

    register_block_pattern_category( 'kiosk', array( 'label' => 'Kiosk' ) );

    foreach ( glob( get_stylesheet_directory() . '/block-patterns/*.php' ) as $file ) {
        $pattern = get_file_data( $file, array(
            'title'       => 'Title',
            'description' => 'Description',
        ) );
        ob_start();
        include $file;
        register_block_pattern( 'gp-child/' . basename( $file, '.php' ), array(
            'title'       => $pattern['title'],
            'description' => $pattern['description'],
            'categories'  => array( 'kiosk' ),
            'content'     => ob_get_clean(),
        ) );
    }
} );

/*
 * Sperrbildschirm direkt aus der Vorlage: [kiosk_sperrbildschirm] in der Seite "Sperrseite" zeigt
 * block-patterns/kiosk-sperrbildschirm.php. Änderungen an der Datei gelten sofort, die Vorlage muss
 * nicht mehr neu in die Seite eingefügt werden.
 */
add_shortcode( 'kiosk_sperrbildschirm', function() {
    ob_start();
    include get_stylesheet_directory() . '/block-patterns/kiosk-sperrbildschirm.php';
    // Shortcode-Blöcke kommen von do_blocks in <p> verpackt; das leere <p> daneben wäre im Flex-Layout
    // ein eigener Eintrag mit Abstand
    return do_shortcode( shortcode_unautop( do_blocks( ob_get_clean() ) ) );
} );
