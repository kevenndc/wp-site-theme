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

/**
 * Defines the panel of Colors customization for the theme
 * 
 * @return array An array of panels, containing sections which contain settings
 */
function get_color_panel() {

  $output = array();

  $output['colors'] = array(
    'title'       => esc_html__( 'Colors', 'wp_site_theme' ),
    'description' => esc_html__( 'Customize the colors of the theme', 'wp_site_theme' ),
    'priority'    => 20,
    'sections'    => array(),
  );

  // Define the desktop section, wich resides in the colors panel
  $output['colors']['sections']['desktop'] = array(
    'title'       => esc_html__( 'Desktop', 'wp_site_theme' ),
    'description' => esc_html__( 'Colors for desktop (default) devices' ),
    'priority'    => 20,
    'settings'    => array(),
  );

  $output['colors']['sections']['desktop']['link_color'] = array(
    'type'                 => 'color',
    'label'                => esc_html__( 'Link color', 'wp_site_theme' ),
    'description'          => esc_html__( 'The color of the links', 'wp_site_theme' ),
    'priority'             => 10,
    'default'              => '#0000ee',
    'sanitize_callback'    => 'sanitize_hex_color',
    'sanitize_js_callback' => 'sanitize_hex_color',
    'css' => array(),
  );
}