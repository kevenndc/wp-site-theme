<?php

require_once get_template_directory() . '/classes/class-theme-mods.php';

class WP_Site_Theme_Customizer {

  public function __construct() {
    //add_action( 'customize_register', array( $this, 'header_customizer' ) );
    //add_action( 'customize_manager', array( $this, 'header_customizer' ) );
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

  public function register( $wp_customize ) {
    $theme_mods = new WP_Site_Theme_Mods();
    $panels     = $theme_mods->get_panels();

    var_dump( $theme_mods  );

    echo $panels;

    foreach ( $panels as $panel_id => $panel ) {

      // adds all panels to the UI
      $wp_customize->add_panel(
        $panel_id,
        array(
          'title'       => $panel['title'],
          'description' => $panel['description'],
          'priority'    => $panel['priority'],
        )
      );

      // adds each section of this panel to the UI
      foreach ( $panel['section'] as $_section_id => $section ) {
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
      
        // adds each setting of the section in the UI
        foreach ( $section['settings'] as $_setting_id => $setting ) {
          $setting_id  = "{$panel_id}_{$section_id}_{$_setting_id}";

          // array of arguments for the setting
          $setting_args = array(
            'default'               => $setting['default'],
            'sanitize_callback'     => $setting['sanitize_callback'],
            'sanitize_js_callback'  => $setting['sanitize_js_callback'],
          );

          // register the setting
          $wp_customize->add_setting( $setting_id, $setting_args );

          $control_args = array(
            'label'       => $setting['label'],
            'section'     => $section_id,
            'type'        => $setting['type'],
            'description' => $setting['description'],
          );

          // register the setting control
          $wp_customize->add_control( $setting_id, $setting_args );
        }

      }
    }
  }
}
