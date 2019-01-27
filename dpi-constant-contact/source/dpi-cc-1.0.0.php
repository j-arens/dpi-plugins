<?php

/*
Plugin Name: DPI Constant Contact Integration
Plugin URI: http://www.diocesan.com
Description: Easily link your constant contact account to your webforms.
Version: 1.0.0
Author: Diocesan Publications
Author URI: http://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/classes/DPI_CC_Plugin_Page.php';
require_once __DIR__ . '/classes/DPI_CC_Shortcode.php';
require_once __DIR__ . '/classes/DPI_CC_Form_Control.php';

define( 'DPI_CC_VERSION', '1.0.0' );

class DPI_CC_Init {

  private $plugin_page;
  private $shortcode;
  private $form_control;

  public function __construct() {
    register_activation_hook( __FILE__, [$this, 'install'] );
    // $this->check_for_updates();
    $this->load_plugin();
  }

  public function install() {
    update_option( 'dpi_cc_version', DPI_CC_VERSION );
    update_option( 'dpi_cc_access_token', false );
  }

  private function check_for_updates() {
    if ( intval( DPI_CC_VERSION ) < 2 ) {
      Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/j-arens/',
        __FILE__,
        'dpi-cc-' . DPI_CC_VERSION
      );
    }
  }

  private function load_plugin() {
    // have to load this now otherwise ajax handlers wont work
    $this->form_control = new DPI_CC_Form_Control;

    if ( is_admin() ) {
      $this->plugin_page = new DPI_CC_Plugin_Page();
    } else {
      $this->shortcode = new DPI_CC_Shortcode( $this->form_control );
    }
  }
}

new DPI_CC_Init();
