<?php

class WP_Site_Theme_Customizer {

  static $settings = array();

  public function __construct() {
    //add_action( 'customize_register', array( $this, 'header_customizer' ) );
    add_action( 'customize_register', array( $this, 'header_customizer' ) );
    
    add_action( 'customize_register', array( $this, 'register' ) );
  }

  /**
  * Header Settings
  */
  public function header_customizer( $wp_customize ) {
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

  public function register( $wp_customize ) {
    $theme_mods = new WP_Site_Theme_Mods();
    $panels     = $theme_mods->get_panels();

    foreach ( $panels as $panel_id => $panel ) {

      // add all panels to the UI
      $wp_customize->add_panel(
        $panel_id,
        array(
          'title'       => $panel['title'],
          'description' => $panel['description'],
          'priority'    => $panel['priority'],
        )
      );

      // add each section of this panel to the UI
      foreach ( $panel['sections'] as $_section_id => $section ) {
        $section_id = "{$panel_id}_{$_section_id}";
        

        $wp_customize->add_section(
          $section_id,
          array(
            'title'       => $section['title'],
            'description' => $section['description'],
            'priority'    => $section['priority'],
            'panel'       => $panel_id,
          )
        );
      
        // add each setting of the section in the UI
        foreach ( $section['settings'] as $_setting_id => $setting ) {
          $setting_id   = "{$section_id}_{$_setting_id}";

          // array of arguments for the setting
          $setting_args = array(
            'default'               => $setting['default'],
            'sanitize_callback'     => $setting['sanitize_callback'],
          );

          // register the setting
          $wp_customize->add_setting( $setting_id, $setting_args );

          $control_args = array(
            'setting_id'  => $setting_id,
            'args'        => array(
              'label'       => $setting['label'],
              'section'     => $section_id,
              'type'        => $setting['type'],
              'description' => $setting['description'],
            )
          );

          // passes the $wp_customize object and the $control_args to a function to handle
          $this->add_control( $wp_customize, $control_args );
        }
      }
    }
  }

  /**
   * Handles the insertion of the new control by verifying its type and creating a new object accordingly
   * 
   * @param WP_Customize_Manager $wp_customize
   * @param array $control_args
   */
  public function add_control( $wp_customize, $control_args ) {
    $setting_id = $control_args['setting_id'];
    $args       = $control_args['args'];

    if ( 'color' === $args['type'] ) {
      $wp_customize->add_control(

        /**
         * https://developer.wordpress.org/reference/classes/wp_customize_color_control/
         */
        new WP_Customize_Color_Control(
          $wp_customize,
          $setting_id,
          $args,
        )
      );
    }
    elseif ( 'image' === $args['type'] ) {
      $wp_customize->add_control(

      /**
       * https://developer.wordpress.org/reference/classes/wp_customize_image_control/
       */
        new WP_Customize_Image_Control(
          $wp_customize, 
          $setting_id,
          $args,
        )
      );
    }
    // if the new control has no type that requires specific controls, then use the controls of WP_Customize_Manager
    else {
      $wp_customize->add_control( $setting_id, $args );
    }
  }
}
