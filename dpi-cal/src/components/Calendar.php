<?php

/*
This file outputs the calendar via shortcode [dpi_cal].

Shortcode attributes are optional:
  - selector = the selector of the root container for the calendar, default is '#dpi-cal'.
  - view = the layout of the calendar, can be either 'month' or 'listWeek', default is 'month'.
  - color = the background color of events, can be any css value such as hex, rgb, or a string like 'red', default is '#3a87ad'.
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Calendar {

  /**
  * Constructor
  */
  public function __construct( $plugin_dir_url ) {

    $this->plugin_dir_url = $plugin_dir_url;

    // add shortcode
    add_shortcode( 'dpi_cal', [ $this, 'dpi_cal_shortcode' ] );

    // enqueue styles and scripts
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
  }

  /**
  * Enqueue scripts and styles
  */
  public function enqueue_assets() {

    // moment.js
    wp_register_script( 'dpi-cal-moment', $this->plugin_dir_url . 'assets/js/moment.min.js', true );
    wp_enqueue_script( 'dpi-cal-moment' );

    // fullcalendar.js
    wp_register_script( 'dpi-cal', $this->plugin_dir_url . 'assets/js/fullcalendar.min.js', [ 'jquery', 'dpi-cal-moment' ], true );
    wp_enqueue_script( 'dpi-cal' );

    // gcal.js
    wp_register_script( 'dpi-cal-gcal', $this->plugin_dir_url . 'assets/js/gcal.js', true );
    wp_enqueue_script( 'dpi-cal-gcal' );

    // protected
    wp_register_script( 'dpi-cal-protected', $this->plugin_dir_url . 'assets/js/cal-modals.js', true );

    // fullcalendar css
    wp_register_style( 'dpi-cal-styles', $this->plugin_dir_url . 'assets/css/fullcalendar.css', '1.0.0', 'all' );
    wp_enqueue_style( 'dpi-cal-styles' );
  }

  /**
  * Shortcode handler
  */
  public function dpi_cal_shortcode( $atts ) {
    $args = shortcode_atts(
      array(
        'selector' => '#dpi-cal',
        'color' => '#3a87ad',
        'view' => 'month',
      ), $atts );

    // make sure the view provided by user is an actual view we can use
    if ( $args['view'] !== 'listWeek' || $args['view'] !== 'month' ) {
      $args['view'] = 'month';
    }

    // set selector for container div
    $selector_type = $this->selector_type( $args['selector'] );
    $string = $this->strip_selector( $args['selector'] );

    // get settings from plugin page
    $calendar_api = get_option( 'dpi_cal_api_key' );
    $calendar_id = get_option( 'dpi_cal_cal_id' );

    // can only run if we have an id and api key
    if ( empty( $calendar_api ) || empty( $calendar_id ) ) {
      exit();
    } else {

      // vars to pass into script
      $translation = array(
        'selector' => $args['selector'],
        'view' => $args['view'],
        'event_color' => $args['color'],
        'api' => $calendar_api,
        'id' => $calendar_id
      );

      // inject data into script
      wp_localize_script( 'dpi-cal-protected', 'dpi_cal_opts', $translation );
      wp_enqueue_script( 'dpi-cal-protected' );

      // root
      $html = '
        <div ' . $selector_type . '"' . $string .'"></div>
      ';

      return $html;
    }
  }

  /**
  * Get selector type
  */
  public function selector_type( $string ) {
    $selector_type = '';

    if ( preg_match( '/([#])\w+/', $string ) ) {
      $selector_type = 'id=';
    } else if ( preg_match( '/([.])\w+/', $string ) ) {
      $selector_type = 'class=';
    }

    return $selector_type;
  }

  /**
  * Strip selector of # or .
  */
  public function strip_selector( $string ) {
    $bad_chars = array('.', '#');

    $stripped_selector = str_replace( $bad_chars, '', $string );

    return $stripped_selector;
  }
}
