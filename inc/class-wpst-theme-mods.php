<?php

final class WPST_Theme_Mods {

  private function __construct() {}

  /**
   * Defines the panel of Colors customization for the theme
   * 
   * @return array An array of panels, containing sections which contain settings
   */
  public static function get_panels() {

    $config   = array();
    $devices  = array ( 'desktop', 'tablet', 'mobile' );

    /* ---- COLORS ---- */

    $config['colors'] = array(
      'title'       => esc_html__( 'Colors', WPST_THEME ),
      'description' => esc_html__( 'Customize the colors of the theme', WPST_THEME ),
      'priority'    => 20,
      'sections'    => array(),
    );

    $config['colors']['sections']['typography'] = array(
      'title'       => esc_html__( 'Text colors', WPST_THEME ),
      'description' => esc_html__( 'Default text colors.', WPST_THEME ),
      'priority'    => 20,
      'settings'    => array(),
    );

    $config['colors']['sections']['typography']['settings']['link_color'] = array(
      'type'                 => 'color',
      'label'                => esc_html__( 'Link color', WPST_THEME ),
      'description'          => esc_html__( 'The color of the links', WPST_THEME ),
      'priority'             => 10,
      'default'              => '#0000ee',
      'sanitize_callback'    => 'sanitize_hex_color',

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => 'a',
          'property'  => 'color',
        )
      ),
    );

    $config['colors']['sections']['typography']['settings']['link_color_hover'] = array(
      'type'                 => 'color',
      'label'                => esc_html__( 'Link color on hover', WPST_THEME ),
      'description'          => esc_html__( 'The color of the links on hover', WPST_THEME ),
      'priority'             => 9,
      'default'              => '#0000ee',
      'sanitize_callback'    => 'sanitize_hex_color',

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => 'a:hover',
          'property'  => 'color',
        )
      ),
    );

    $config['colors']['sections']['typography']['settings']['body_text'] = array(
      'type'                 => 'color',
      'label'                => esc_html__( 'Body text', WPST_THEME ),
      'description'          => esc_html__( 'The default color of the body text', WPST_THEME ),
      'priority'             => 8,
      'default'              => '#666',
      'sanitize_callback'    => 'sanitize_hex_color',

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => 'a:hover',
          'property'  => 'color',
        )
      ),
    );

    /* ---- BACKGROUND ---- */

    $config['background'] = array(
      'title'       => esc_html__( 'Background', WPST_THEME ),
      'description' => esc_html__( 'Theme background options', WPST_THEME ),
      'priority'    => 19,
      'sections'    => array(),
    );

    $config['background']['sections']['desktop'] = array(
      'title'       => esc_html__( 'Default (Desktop)', WPST_THEME ),
      'description' => esc_html__( 'Background options for desktop devices.', WPST_THEME ),
      'priority'    => 1,
      'settings'    => array(),
    );

    $config['background']['sections']['tablet'] = array(
      'title'       => esc_html__( 'Tablet', WPST_THEME ),
      'description' => esc_html__( 'Background options for tablet devices.', WPST_THEME ),
      'priority'    => 2,
      'settings'    => array(),
    );

    $config['background']['sections']['mobile'] = array(
      'title'       => esc_html__( 'Mobile', WPST_THEME ),
      'description' => esc_html__( 'Background options for mobile devices.', WPST_THEME ),
      'priority'    => 1,
      'settings'    => array(),
    );


    $bg_image_args = array(
      // the meta key is used for storing values wich will only be used to create this setting in diferent sections for the same panel.
      'meta'  => array(
        'setting_key' => 'header_background_image',
        'devices'     =>  $devices,
      ),

      'type'              => 'image',
      'label'             => esc_html__( 'Header background image', WPST_THEME ),
      'description'       => esc_html__( 'The header background image', WPST_THEME ),
      'priority'          => 10,
      'default'           => '',
      'sanitize_callback' => array( __CLASS__, 'WPST_sanitize_file' ),

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => '.header-top-bg',
          'property'  => 'background-image',
        )
      ),
    );
    self::set_setting_for_all_devices( $config['background']['sections'], $bg_image_args );
    
    $header_bg_pos_args =  array (
      'meta'  => array(
        'setting_key' => 'header_background_position',
        'devices'     =>  $devices,
      ),
      'type'              => 'select',
      'label'             => esc_html__( 'Header background position', WPST_THEME ),
      'description'       => esc_html__( 'Controls the header background position', WPST_THEME ),
      'priority'          => 9,
      'default'           => 'center',
      'sanitize_callback' => array( __CLASS__, 'WPST_sanitize_select' ),
      'css'               => array(
        array(
          'selector'  => '.header-background-position',
          'property'  => 'background-position',
        )
      ),
      'choices'         => array (
        'center'        => esc_html__( 'Center', WPST_THEME ),
        'center top'    => esc_html__( 'Center top', WPST_THEME ),
        'center bottom' => esc_html__( 'Center bottom', WPST_THEME ),
        'top right'     => esc_html__( 'Top right', WPST_THEME ),
        'top left'      => esc_html__( 'Top left', WPST_THEME ),
        'bottom right'  => esc_html__( 'Bottom right', WPST_THEME ),
        'bottom left'   => esc_html__( 'Bottom left', WPST_THEME ),
        'right'         => esc_html__( 'Right', WPST_THEME ),
        'left'          => esc_html__( 'Left', WPST_THEME ),
      ),
      
    );
    self::set_setting_for_all_devices( $config['background']['sections'], $header_bg_pos_args );

    return $config;
  }

  /**
   * Checks if the input file is valid by checking its extension.
   * 
   * This function is used for image type settings.
   * 
   * @param string $filename The file name or path.
   * @param Object $setting The setting object.
   * 
   * @return boolean Returns TRUE if the file extension is valid and FALSE if it isn't.
   */
  function WPST_sanitize_file( $filename, $setting ) {
          
    // allowed file types
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png'
    );
      
    // check file type from file name
    $file_ext = wp_check_filetype( $filename, $mimes );
      
    // if file has a valid mime type return it, otherwise return default
    return ( $file_ext['ext'] ? $filename : $setting->default );
  }

  /**
  * Checks if the input option exists in the setting select choices
  * 
  * This function is used for select type settings.
  * 
  * @param string $input The key of the choice.
  * @param Object $setting The setting object.
  * 
  * @return boolean Returns TRUE if the file extension is valid and FALSE if it isn't.
  */
  function WPST_sanitize_select( $input, $setting ) {
            
    // input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key( $input );

    // get the list of possible select options 
    $choices = $setting->manager->get_control( $setting->id )->choices;
                      
    // return input if valid or return default option
    return array_key_exists( $input, $choices ) ? $input : $setting->default;                
        
  }

  /**
   * Get all WPST theme customizer settings and its values.
   * 
   * @return array An array with all settings and its values
   */
  public static function get_settings() {
    $settings = array();
    $panels   = self::get_panels();

    foreach ( $panels as $panel_id => $panel ) {
      foreach ( $panel['sections'] as $section_id => $section ) {
        foreach ( $section['settings'] as $setting_id => $setting ) {

          $setting_key    = sprintf( WPST_SETTING_FORMAT, $panel_id, $section_id, $setting_id );
          $setting_value  = get_theme_mod( $setting_key );

          if ( empty( $setting_value ) ) { continue; } 

          // add the user defined value into the setting definition array
          $setting['value'] = $setting_value;

          $settings[ $setting_key ] = $setting;
        } 
      }
    }

    return $settings;
  }

  /**
   * Utilitary function to insert the same setting config into diferent device panels
   */
  private static function set_setting_for_all_devices( &$sections, $setting_config ) {
    $setting_key  = $setting_config['meta']['setting_key'];
    $devices      = $setting_config['meta']['devices'];

    unset( $setting_config['meta'] );

    foreach ( $devices as $device ) {
      if ( isset( $sections[$device]['settings'] ) ) {
        $setting_config['device'] = $device;
        $sections[$device]['settings'][$setting_key] = $setting_config;
      }
    }
  }
}

