<?php

class WPST_Theme {
  
  public function __construct() { }

  public static function setup() {
    self::setup_constants();
    self::setup_customizer();
  }

  private static function setup_constants() {
    // default path to WPST theme files
    define( 'WPST_INC_PATH', trailingslashit( get_template_directory( __FILE__ ) . '/inc/' ) );

    // theme prefix
    define( 'WPST_PREFIX', 'wpst' );

    // the setting id default format
    define( 'WPST_SETTING_FORMAT', WPST_PREFIX . '_%s_%s_%s' );
  }

  /**
   * Includes all the theme classes
   */
  private static function setup_customizer() {
    require_once WPST_INC_PATH . 'class-wpst-theme-customizer.php';
    require_once WPST_INC_PATH . 'class-wpst-theme-mods.php';
    new WPST_Theme_Customizer();
  }
}