<?php

/*
This file controls the plugin output on the backend of the site.
This class creates a plugin page called DPI Calendar that can be found under Plugins > DPI Calendar.
Fields are NOT optional - you must input a calendar id and api key for this plugin to work.

To do:
  - Stop using simcal's api key instructions

Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Cal_Backend {

  /**
  * Constructor
  */
  public function __construct( $plugin_dir_url ) {

    $this->plugin_dir_url = $plugin_dir_url;

    // add plugin page
    add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );

    // enqueue plugin page styles
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

    // page and settings output
    add_action( 'admin_init', array($this, 'page_init') );
  }

  /**
  * Enqueue admin page assets
  */
  public function enqueue_admin_assets() {

    // styles for plugin settings page
    wp_register_style( 'dpi_cal_plugin_page_styles', $this->plugin_dir_url . 'assets/css/plugin-page.css', '1.0.0', 'all' );
  }

  /**
  * Add plugin page
  */
  public function add_plugin_page() {

    // page settings
    add_plugins_page(
      'DPI Calendar Settings', // page title
      'DPI Calendar', // menu title
      'moderate_comments', // capability
      'dpi-cal-settings', // menu slug
      array( $this, 'create_page' ) // page callback
    );
  }

  /**
  * Page callback
  */
  public function create_page() {

    wp_enqueue_style( 'dpi_cal_plugin_page_styles' );
    
    ?>
      <div id="dpi_cal_settings_page" class="wrap">
        <h1>DPI Calendar</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
          <?php

            // print hidden fields with redirects/etc...
            settings_fields( 'settings_section' );

            // add sections and fields
            do_settings_sections( 'cal_options' ); // group id

            // guess what this does...
            submit_button();
          ?>
        </form>
      </div>
    <?php
  }

  /**
  * Page init
  */
  public function page_init() {

    // add settings groups
    add_settings_section(
        'settings_section', // string for use in the id attribite, match settings_fields()
        'Calendar Settings', // section title
        array( $this, 'print_errors' ), // section header callback
        'cal_options' // matches do settings_sections
    );

    // calendar id field
    add_settings_field(
        'dpi_cal_cal_id', // string for use in the id attr
        'Calendar ID', // title of the field
        array( $this, 'cal_id_callback' ), // output callback
        'cal_options', // matches do_settings_section
        'settings_section' // matches settings_fields()
    );

    register_setting(
        'settings_section', // matches settings_fields()
        'dpi_cal_cal_id', // name of option to sanitize and save, matches first param of add_settings_field
        array( $this, 'sanitize' ) // callback validation
    );

    // api key field
    add_settings_field(
      'dpi_cal_api_key',
      'Api Key',
      array( $this, 'api_key_callback' ),
      'cal_options',
      'settings_section'
    );

    register_setting(
      'settings_section',
      'dpi_cal_api_key',
      array( $this, 'sanitize' )
    );

    // enable events field
    add_settings_field(
        'dpi_cal_enable_events',
        'Enable event shortcode',
        array( $this, 'events_callback' ),
        'cal_options',
        'settings_section'
    );

    register_setting(
        'settings_section',
        'dpi_cal_enable_events',
        array( $this, 'sanitize' )
    );

    // quantity of events field
    add_settings_field(
        'dpi_cal_event_quantity',
        'Quantity of events',
        array( $this, 'event_quantity_callback' ),
        'cal_options',
        'settings_section'
    );

    register_setting(
        'settings_section',
        'dpi_cal_event_quantity',
        array( $this, 'sanitize' )
    );
  }

  /**
   * Print settings section header
   */
  public function print_errors() {
      // settings_errors();
  }

  /**
   * Settings fields callbacks
   */
  public function cal_id_callback() {
    printf(
      '<input type="text" id="dpi_cal_cal_id" name="dpi_cal_cal_id" value="%s" />',
      !empty( get_option( 'dpi_cal_cal_id' ) ) ? get_option( 'dpi_cal_cal_id' ) : ''
    );
  }

  public function api_key_callback() {
    printf(
      '<input type="text" id="dpi_cal_api_key" name="dpi_cal_api_key" value="%s" />
      <a target="_blank" href="http://docs.simplecalendar.io/google-api-key/?utm_source=inside-plugin&utm_medium=link&utm_campaign=core-plugin&utm_content=settings-link">Api key instructions</a>',
      !empty( get_option( 'dpi_cal_api_key' ) ) ? get_option( 'dpi_cal_api_key' ) : ''
    );
  }

  public function events_callback() {
    printf(
        '<input type="checkbox" id="dpi_cal_enable_events" name="dpi_cal_enable_events" %s />',
        !empty( get_option( 'dpi_cal_enable_events' ) ) ? 'checked' : ''
    );
  }

  public function event_quantity_callback() {
    printf (
      '<input type="number" id="dpi_cal_event_quantity" name="dpi_cal_event_quantity" min="1" max="100" value="%s"',
      !empty( get_option( 'dpi_cal_event_quantity' ) ) ? get_option( 'dpi_cal_event_quantity' ) : ''
    );
  }

  /**
  * Sanitize and validate callback
  */
  public function sanitize( $input ) {
    $new_input = '';

    // validate settings
    if ( empty( $input ) ) {
      add_settings_error(
        'dpi_cal_auth',
        'setting-error auth-error',
        'Missing ID and/or API Key!',
        'notice notice-error is-dismissible'
      );
    }

    // sanitize strings and make integers non-negative
    if ( is_string( $input ) ) {
      $new_input = sanitize_text_field( $input );
    } else if ( is_int( $input ) ) {
      $new_input = absint( $input );
    } else {
      $new_input = $input;
    }

    return $new_input;
  }
}
