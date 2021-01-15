<?php

function wp_site_theme_setup() {
    // Let Wordpress provide the <title> tag for the document.
    add_theme_support( 'title-tag' );

    // Enable Post Thumbnails for Posts and Pages.
    add_theme_support( 'post-thumbnails' );

    // Load theme domain
    load_theme_textdomain( 'wp-site-theme', get_template_directory_uri() . '/languages' );

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support(
        'html5',
        array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'navigation-widgets',
        )
    );

    register_nav_menus(
        array(
            'primary'   => esc_html__( 'Primary menu', 'wp_site_theme' ),
            'footer'    => esc_html__( 'Footer menu', 'wp_site_theme' ),
        )
    );
}

add_action( 'after_setup_theme', 'wp_site_theme_setup' );

// Enqueue theme CSS styles
function setup_wp_site_theme_styles() {
    // Add de Theme custom style
    wp_enqueue_style( 'wp-site-theme-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ), wp_get_theme()->get( 'Version' ) );
    
    // Includes Bootstrap css to theme
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.4.1', 'all');
}

// Add theme enqueued CSS styles
add_action( 'wp_enqueue_scripts', 'setup_wp_site_theme_styles');

// Enqueue theme JS 
function setup_wp_site_theme_scripts() {
    // Add Bootstrap js to theme
    wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), '4.1.3', true);
    // Add Bootstrap js to theme
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery', 'popper'), '4.1.3', true);
}

// Add theme enqueued theme JS
add_action( 'wp_enqueue_scripts', 'setup_wp_site_theme_scripts');

// Register custom Navwalker
function register_navwalker(){
	require_once get_template_directory() . '/assets/php/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );
