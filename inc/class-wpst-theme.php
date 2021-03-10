<?php

class WPST_Theme {
  
  public function __construct() { }

  public static function setup() {
    self::setup_constants();
    self::setup_customizer();
  }

  private static function setup_constants() {
    define( 'THEME_PREFIX', 'wpst' );
  }

  private static function setup_customizer() {
    require_once WPST_INC_PATH . 'class-wpst-theme-customizer.php';
    require_once WPST_INC_PATH . 'class-wpst-theme-mods.php';
    new WPST_Theme_Customizer();
  }
}