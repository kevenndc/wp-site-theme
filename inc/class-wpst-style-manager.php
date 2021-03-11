<?php

/**
 * THis class is responsible to create
 */
class WP_Site_Theme_Style_Manager {

  public function __construct( array $settings, $output_for = 'front_end') {
    add_action( 'wp_enqueue_scripts', array( $this, 'front_end_styles' ) );
  }

  public function front_end_styles() {
    // code here
  }

  /**
   * Loop through theme mods ands builds a string of CSS rules.
   */
  public function get_inline_styles( $wrapped = 'wrapped', $output_for = 'front_end' ) {
    $styles = '';

    
  }
}