<?php

class WPST_Theme {
  
  public function __construct() { }

  public static function setup() {
    self::setup_constants();
    self::enqueue_scripts();
    self::require_classes();
    self::setup_customizer();
  }

  private static function setup_constants() {
    // default path to WPST theme files
    define( 'WPST_INC_PATH', trailingslashit( get_template_directory( __FILE__ ) . '/inc/' ) );

    // default path to WPST theme JavaScript files
    define( 'WPST_JS_URI', get_template_directory_uri( __FILE__ ) . '/js/' );

    // the theme namespace
    define( 'WPST_THEME', 'wpst_theme' );

    // theme prefix
    define( 'WPST_PREFIX', 'wpst' );

    // the setting id default format
    define( 'WPST_SETTING_FORMAT', WPST_PREFIX . '_%s_%s_%s' );

    // the default media query format for tablet devices
    define( 'WPST_TABLET_QUERY', '@media only screen and (min-width: 601px) and (max-width: 1024px) { %s }' );

    // the default media query format for mobile devices
    define( 'WPST_MOBILE_QUERY', '@media only screen and (max-width: 600px) { %s }' );
  }

  /**
   * Includes all the theme necessary classes
   */
  private static function require_classes() {
    require_once WPST_INC_PATH . 'class-wpst-theme-customizer.php';
    require_once WPST_INC_PATH . 'class-wpst-theme-mods.php';
    require_once WPST_INC_PATH . 'class-wpst-style-manager.php';
    require_once WPST_INC_PATH . 'class-wp-bootstrap-navwalker.php';
  }

  private static function setup_customizer() {
    new WPST_Theme_Customizer();
    new WP_Site_Theme_Style_Manager();
  }

  static function wpst_stylesheets() {
    // Add de Theme custom style
    wp_enqueue_style( WPST_THEME, get_template_directory_uri() . '/style.css', array( 'bootstrap' ), wp_get_theme()->get( 'Version' ) );
    
    // Includes Bootstrap css to theme
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.4.1', 'all');
  }

  static function wpst_scripts() {
    // Add Bootstrap js to theme
    wp_enqueue_script('popper', WPST_JS_URI .'popper.min.js', array('jquery'), '4.1.3', true);
    // Add Bootstrap js to theme
    wp_enqueue_script('bootstrap', WPST_JS_URI . 'bootstrap.min.js', array('jquery', 'popper'), '4.1.3', true);
  }

  static function enqueue_scripts() {
    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wpst_stylesheets' ) );
    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wpst_scripts') );
  } 

}