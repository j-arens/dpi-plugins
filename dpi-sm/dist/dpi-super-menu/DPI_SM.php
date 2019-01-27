<?php

/*
Plugin Name: DPI Super Menu
Plugin URI: http://www.diocesan.com
Description: Powerful site navigation editor.
Author: Josh Arens
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// namespace DPI_SM;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// use DPI_SM\DPI_SM_CPT;
// use DPI_SM\DPI_SM_Menu_Editor;
// use DPI_SM\DPI_SM_Shortcode;

define( 'DPI_SM_DIR', trailingslashit( dirname( __FILE__ ) ) );

require_once( dirname( __FILE__ ) . '/class/DPI_SM_CPT.php' );
require_once( dirname( __FILE__ ) . '/class/DPI_SM_Menu_Editor.php' );
require_once( dirname( __FILE__ ) . '/class/DPI_SM_Shortcode.php' );

class DPI_SM {

  public static function init() {

    // add our cpt and menu editor meta box if it doesn't already exist
    if ( !post_type_exists( 'dpi_super_menu' ) ) {
      new DPI_SM_CPT();
    }

    // conditionally run our code based on currednt view
    if ( !is_admin() ) {
      new DPI_SM_Shortcode();
    } else {
      new DPI_SM_Menu_Editor();
    }
  }
}

DPI_SM::init();
