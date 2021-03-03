<?php

class WP_Site_Theme_Customizer {

  public function __construct() {
    //add_action( 'customize_register', array( $this, 'header_customizer' ) );
    add_action( 'customize_manager', array( $this, 'register' ) );
  }

  /**
  * Header Settings
  */
  function header_customizer( $wp_customize ) {
    $wp_customize->add_setting( 'set_header_bg' );
    $wp_customize->add_setting( 'set_header_bg_position' );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize, 'set_header_bg', array(
          'label'     => __( 'Header background image', 'wp_site_theme' ),
          'section'   => 'title_tagline',
          'setting'   => 'set_header_bg',
          'priority'  => 1,
        )
      )
    );

    $wp_customize->add_control(
      'set_header_bg_position', array(
        'label'     => __( 'Header background position', 'wp_site_theme' ),
        'section'   => 'title_tagline',
        'setting'   => 'set_header_bg_position',
        'type'      => 'select',
        'choices'   => array(
          'center'        => __(' Center', 'wp_site_theme' ),
          'center top'    => __( 'Center top', 'wp_site_theme' ),
          'center right'  => __( 'Center right', 'wp_site_theme' ),
          'center bottom' => __( 'Center bottom', 'wp_site_theme' ),
          'center left'   => __( 'Center left', 'wp_site_theme' ),
          'top'           => __( 'Top', 'wp_site_theme' ),
          'top right'     => __( 'Top right', 'wp_site_theme' ),
          'top left'      => __( 'Top left', 'wp_site_theme' ),
          'bottom'        => __( 'Bottom', 'wp_site_theme' ),
          'bottom right'  => __( 'Bottom right', 'wp_site_theme' ),
          'bottom left'   => __( 'Bottom left', 'wp_site_theme' ),
          'right'         => __( 'Bottom right', 'wp_site_theme' ),
          'left'          => __( 'Left', 'wp_site_theme' ),
        )
      )
    );
  }
}
