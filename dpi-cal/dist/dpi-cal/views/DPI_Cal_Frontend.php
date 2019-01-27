<?php

/*
This file controls the plugin output on the frontend of the site via the shortcode [dpi_cal].

To do:
  - better variable checking and error reporting

Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

include( plugin_dir_path( __FILE__ ) . '../components/Calendar.php' );
include( plugin_dir_path( __FILE__ ) . '../components/Events_list.php' );

class DPI_Cal_Frontend {

  /**
  * Constructor
  */
  public function __construct( $plugin_dir_url ) {

    $this->plugin_dir_url = $plugin_dir_url;

    // instantiate calendar
    $calendar = new Calendar( $plugin_dir_url );

    // instantiate events only if checked in settings
    if ( get_option( 'dpi_cal_enable_events' ) === 'on' ) {
      $events = new Events_List( $plugin_dir_url );
    }
  }
}
