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
    $styles       = '';

    // the default media query format for tablet devices
    $tablet_query = '@media only screen and (min-width: 601px) and (max-width: 1024px) { %s }';

    // this variable will concatenate all the css rules for tablet devices
    $tablet_rules = '';

    // the default media query format for mobile devices
    $mobile_query = '@media only screen and (max-width: 600px) { %s }';
    
    // this variable will concatenate all the css rules for mobile devices
    $mobile_rules = '';
    $settings     = WPST_Theme_Mods::get_settings();

    foreach ( $settings as $setting_id => $setting ) {
      $css_rules  = $setting['css'];
      $value      = $setting['value'];

      foreach ( $css_rules as $css ) {
        $selector = $css['selector'];
        $property = $css['property'];

        $rule = "$selector { $property: $value };";

        // check if the current rule is for a specific device
        if ( isset( $setting['device'] ) ) {

          if ( 'tablet' === $setting['device'] ) {
            $tablet_rules .= $rule;
          }
          else if ( 'mobile' === $setting['device'] ) {
            $mobile_rules .= $rule;
          }

        }
        else {
          $styles .= $rule;
        }
      } 
    }

    // creates and add the media query for tablet devices with all its rules to the inline styles
    $styles .= sprintf( $tablet_query, $tablet_rules );

    // create and add the media query for mobile devices with all its rules to the inline styles
    $styles .= sprintf( $mobile_query, $mobile_rules );

    
    return $styles;
  }
}