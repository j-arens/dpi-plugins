<?php

/*
Plugin Name: DPI Staff
Plugin URI: http://www.diocesan.com
Description: Easily manage and present staff members.
Author: Diocesan Publications
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define( 'DPI_STAFF_DIR', plugins_url() . '/dpi-staff' ); // - using a constant because wordpress plugin dir functions never seem to cover all of my use cases...

include( dirname( __FILE__ ) . '/Class/DPI_Staff_Shortcode.php' );
include( dirname( __FILE__ ) . '/Class/DPI_Staff_Admin.php' );

if ( is_admin() ) {
  new DPI_Staff_Admin();
} else {
  new DPI_Staff_Shortcode();
}
