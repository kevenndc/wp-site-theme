<?php

class WP_Site_Theme_Customizer {

  public function __construct() {
    add_action( 'customize_register', array( $this, 'header_customizer' ) );
  }

  /**
  * Header Settings
  */
  function header_customizer( $wp_customize ) {
    $wp_customize->add_setting( 'set_header_bg' );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize, 'set_header_bg', array(
          'label'     => __( 'Header Background Image', 'wp_site_theme' ),
          'section'   => 'title_tagline',
          'setting'   => 'set_header_bg',
          'priority'  => 1,
        )
      )
    );
  }
}