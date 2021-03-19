<?php

class WPST_Theme_Customizer {

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
          'label'     => __( 'Header background image', WPST_THEME ),
          'section'   => 'title_tagline',
          'setting'   => 'set_header_bg',
          'priority'  => 1,
        )
      )
    );

    $wp_customize->add_control(
      'set_header_bg_position', array(
        'label'     => __( 'Header background position', WPST_THEME ),
        'section'   => 'title_tagline',
        'setting'   => 'set_header_bg_position',
        'type'      => 'select',
        'choices'   => array(
          'center'        => __(' Center', WPST_THEME ),
          'center top'    => __( 'Center top', WPST_THEME ),
          'center right'  => __( 'Center right', WPST_THEME ),
          'center bottom' => __( 'Center bottom', WPST_THEME ),
          'center left'   => __( 'Center left', WPST_THEME ),
          'top'           => __( 'Top', WPST_THEME ),
          'top right'     => __( 'Top right', WPST_THEME ),
          'top left'      => __( 'Top left', WPST_THEME ),
          'bottom'        => __( 'Bottom', WPST_THEME ),
          'bottom right'  => __( 'Bottom right', WPST_THEME ),
          'bottom left'   => __( 'Bottom left', WPST_THEME ),
          'right'         => __( 'Bottom right', WPST_THEME ),
          'left'          => __( 'Left', WPST_THEME ),
        )
      )
    );
  }

  public function register( $wp_customize ) {
    $mods   =
    $panels = WPST_Theme_Mods::get_panels();

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
          $setting_id   = sprintf( WPST_SETTING_FORMAT, $panel_id, $_section_id, $_setting_id );

          // array of arguments for the setting
          $setting_args = array(
            'default'               => $setting['default'],
            'sanitize_callback'     => $setting['sanitize_callback'],
          );

          // register the setting
          $wp_customize->add_setting( $setting_id, $setting_args );

          $control = array(
            'setting_id'  => $setting_id,
            'args'        => array(
              'label'       => $setting['label'],
              'section'     => $section_id,
              'type'        => $setting['type'],
              'description' => $setting['description'],
            )
          );

          if ( isset( $setting['choices'] ) ) {
            $control['args']['choices'] = $setting['choices'];
          }

          // passes the $wp_customize object and the $control to a function to handle
          $result = $this->add_control( $wp_customize, $control );

          if ( is_wp_error( $result ) ) {
            echo $result->get_error_message();
          }
        }
      }
    }
    // $mods = get_theme_mods();
    // var_dump( $mods );
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

    return $wp_customize;
  }
}
