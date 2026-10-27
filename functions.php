<?php

add_action( 'wp_enqueue_scripts', function() {

    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'generatepress-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'generatepress-style' ),
        wp_get_theme()->get('Version')
    );

});