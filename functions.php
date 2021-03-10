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

// Enqueue the default theme CSS styles
function setup_wp_site_theme_styles() {
    // Add de Theme custom style
    wp_enqueue_style( 'wp-site-theme-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ), wp_get_theme()->get( 'Version' ) );
    
    // Includes Bootstrap css to theme
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.4.1', 'all');
}

add_action( 'wp_enqueue_scripts', 'setup_wp_site_theme_styles');

// Enqueue the default theme JS  files
function setup_wp_site_theme_scripts() {
    // Add Bootstrap js to theme
    wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), '4.1.3', true);
    // Add Bootstrap js to theme
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery', 'popper'), '4.1.3', true);
}
add_action( 'wp_enqueue_scripts', 'setup_wp_site_theme_scripts');


// Register custom Navwalker
function register_navwalker() {
    require_once get_template_directory() . '/assets/php/class-wp-bootstrap-navwalker.php';
}

add_action( 'after_setup_theme', 'register_navwalker' );

/**
 * Add bootstrap class 'img-fluid' to the custom logo.
 */
function change_logo_class( $html ) {
    $html = str_replace( 'custom-logo', 'custom-logo img-fluid', $html );

    return $html;
}

add_filter( 'get_custom_logo', 'change_logo_class' );

// default path to WPST theme files
define( 'WPST_INC_PATH', trailingslashit( get_template_directory( __FILE__ ) . '/inc/' ) );

// Register theme classes
function register_wp_site_theme_classes() {
    require_once WPST_INC_PATH . 'class-wpst-theme.php';
    WPST_Theme::setup();
}
add_action( 'after_setup_theme', 'register_wp_site_theme_classes' );