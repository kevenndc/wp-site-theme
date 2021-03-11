<?php

class WPST_Theme_Mods {

  public function get_panels() {
    $out = $this->get_color_panel();
    $out = array_merge( $out, $this->get_background_panel() );

    return $out;
  }

  /**
   * Defines the panel of Colors customization for the theme
   * 
   * @return array An array of panels, containing sections which contain settings
   */
  function get_color_panel() {

    $config = array();

    $config['colors'] = array(
      'title'       => esc_html__( 'Colors', 'wp_site_theme' ),
      'description' => esc_html__( 'Customize the colors of the theme', 'wp_site_theme' ),
      'priority'    => 20,
      'sections'    => array(),
    );

    // Define the desktop section inside the colors panel
    $config['colors']['sections']['typography'] = array(
      'title'       => esc_html__( 'Text colors', 'wp_site_theme' ),
      'description' => esc_html__( 'Default text colors.', 'wp_site_theme' ),
      'priority'    => 20,
      'settings'    => array(),
    );

    $config['colors']['sections']['typography']['settings']['link_color'] = array(
      'type'                 => 'color',
      'label'                => esc_html__( 'Link color', 'wp_site_theme' ),
      'description'          => esc_html__( 'The color of the links', 'wp_site_theme' ),
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
      'label'                => esc_html__( 'Link color on hover', 'wp_site_theme' ),
      'description'          => esc_html__( 'The color of the links on hover', 'wp_site_theme' ),
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
      'label'                => esc_html__( 'Body text', 'wp_site_theme' ),
      'description'          => esc_html__( 'The default color of the body text', 'wp_site_theme' ),
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

    return $config;
  }

  function get_background_panel() {
    $config = array();

    $config['background'] = array(
      'title'       => esc_html__( 'Background', 'wp_site_theme' ),
      'description' => esc_html__( 'Theme background options', 'wp_site_theme' ),
      'priority'    => 19,
      'sections'    => array(),
    );

    $config['background']['sections']['desktop'] = array(
      'title'       => esc_html__( 'Default (Desktop)', 'wp_site_theme' ),
      'description' => esc_html__( 'Background options for desktop devices.', 'wp_site_theme' ),
      'priority'    => 1,
      'settings'    => array(),
    );

    $config['background']['sections']['tablet'] = array(
      'title'       => esc_html__( 'Tablet', 'wp_site_theme' ),
      'description' => esc_html__( 'Background options for tablet devices.', 'wp_site_theme' ),
      'priority'    => 2,
      'settings'    => array(),
    );

    $config['background']['sections']['mobile'] = array(
      'title'       => esc_html__( 'Mobile', 'wp_site_theme' ),
      'description' => esc_html__( 'Background options for mobile devices.', 'wp_site_theme' ),
      'priority'    => 1,
      'settings'    => array(),
    );

    $config['background']['sections']['desktop']['settings']['header_background_image'] = array(
      'type'                 => 'image',
      'label'                => esc_html__( 'Header background image', 'wp_site_theme' ),
      'description'          => esc_html__( 'The header background image', 'wp_site_theme' ),
      'priority'             => 10,
      'default'              => '',
      'sanitize_callback'    => array( $this, 'WPST_sanitize_file' ),

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => '.header-top-bg',
          'property'  => 'background-image',
        )
      ),
    );

    $config['background']['sections']['tablet']['settings']['header_background_image'] = array(
      'type'                 => 'image',
      'label'                => esc_html__( 'Header background image', 'wp_site_theme' ),
      'description'          => esc_html__( 'The header background image', 'wp_site_theme' ),
      'priority'             => 9,
      'default'              => '',
      'sanitize_callback'    => array( $this, 'WPST_sanitize_file' ),

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => '.header-top-bg',
          'property'  => 'background-image',
          'queries'   => array(
            'max-width' => '1024px'
          ),
        )
      ),
    );

    $config['background']['sections']['mobile']['settings']['header_background_image'] = array(
      'type'                 => 'image',
      'label'                => esc_html__( 'Header background image', 'wp_site_theme' ),
      'description'          => esc_html__( 'The header background image', 'wp_site_theme' ),
      'priority'             => 8,
      'default'              => '',
      'sanitize_callback'    => array( $this, 'WPST_sanitize_file' ),

      // array of selectors and css propertites which this setting will update
      'css' => array(
        array(
          'selector'  => '.header-top-bg',
          'property'  => 'background-image',
          'queries'   => array(
            'max-width' => '600px'
          ),
        )
      ),
    );

    return $config;
  }

  /**
   * Verifies if the input file is valid by checking its extension.
   * 
   * This function is used for customizer image settings.
   * 
   * @param string $filename The file name or path.
   * @param Object $setting The setting in which the file was uploaded.
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
   * Get all WPST theme customizer settings ans its values.
   * 
   * @return array An array with all settings and its values
   */
  function get_settings() {
    $settings = array();
    $panels   = $this->get_panels();

    foreach ( $panels as $panel_id => $panel ) {
      foreach ( $panels['sections'] as $section_id => $section ) {
        foreach( $section['settings'] as $setting_id => $setting ) {

          $setting_key    = sprintf( WPST_SETTING_FORMAT, $panel_id, $section_id, $setting_id );
          $setting_value  = get_theme_mod( $setting_key );

          if ( empty( $setting_value ) ) { continue; }

          // add the user defined value into the setting definition array
          $setting['value'] = $setting_value;

          $setting[ $setting_key ] = $setting;
        } 
      }
    }

    return $settings;
  }
}

