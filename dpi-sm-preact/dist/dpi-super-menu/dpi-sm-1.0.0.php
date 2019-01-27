<?php

/*
Plugin Name: DPI Super Menu
Plugin URI: http://www.diocesan.com
Description: Powerful site navigation editor.
Author: Josh Arens
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define( 'DPI_SM_DIR', trailingslashit( dirname( __FILE__ ) ) );

require_once( dirname( __FILE__ ) . '/classes/DPI_SM_CPT.php' );
require_once( dirname( __FILE__ ) . '/classes/DPI_SM_Menu_Editor.php' );
// require_once( dirname( __FILE__ ) . '/classes/DPI_SM_Shortcode.php' );

class DPI_SM {

  public function __construct() {
    // register_activation_hook( __FILE__, [$this, 'install'] );
    $this->install();
    $this->load_plugin();
  }

  public function install() {
    if ( !post_type_exists( 'dpi_super_menu' ) ) {
      new DPI_SM_CPT();
    }
  }

  public function load_plugin() {
    if ( !is_admin() ) {
      // new DPI_SM_Shortcode();
    } else {
      new DPI_SM_Menu_Editor();
    }
  }
}

$dpi_sm = new DPI_SM();
