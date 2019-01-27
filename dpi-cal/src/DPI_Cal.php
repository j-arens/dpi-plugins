<?php

/*
Plugin Name: DPI Calendar
Plugin URI: http://www.diocesan.com
Description: Display your google calendar on your site.
Author: Diocesan Publications
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

include( 'views/DPI_Cal_Frontend.php' );
include( 'views/DPI_Cal_Backend.php' );

class DPI_Cal {

  /**
  * Constructor
  */
  public function __construct() {

    // instantiate frontend only if coming from front of site
    if ( !is_admin() ) {
      $frontend = new DPI_Cal_Frontend( plugin_dir_url( __FILE__ ) );
    }

    // instantiate backend only if coming from the wp dashboard
    if ( is_admin() ) {
      $backend = new DPI_Cal_Backend( plugin_dir_url( __FILE__ ) );
    }
  }
}

// instantiate calendar plugin
$dpi_cal = new DPI_Cal();
