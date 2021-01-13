<?php

function setup_theme_styles() {
    wp_enqueue_style( 'bootstrapcss', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.4.1');
}

add_action( 'wp_enqueue_scripts', 'setup_theme_styles');