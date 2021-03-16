<?php
/**
 * Register support for Wordpress features and sets up theme defaults
 */
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

    /**
     * Register the theme's default nav menus.
     * 
     * @link https://codex.wordpress.org/Navigation_Menus
     */
    register_nav_menus(
        array(
            'primary'   => esc_html__( 'Primary menu', 'wp_site_theme' ),
            'footer'    => esc_html__( 'Footer menu', 'wp_site_theme' ),
        )
    );

    /**
     * Add support forv custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support( 'custom-logo', array(

        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
}
add_action( 'after_setup_theme', 'wp_site_theme_setup' );

/**
 * Add bootstrap class 'img-fluid' to the custom logo.
 */
function change_logo_class( $html ) {
    $html = str_replace( 'custom-logo', 'custom-logo img-fluid', $html );

    return $html;
}

add_filter( 'get_custom_logo', 'change_logo_class' );

// Register theme classes
function register_wpst() {
    require_once get_template_directory() . '/inc/class-wpst-theme.php';
    WPST_Theme::setup();
}
add_action( 'after_setup_theme', 'register_wpst' );