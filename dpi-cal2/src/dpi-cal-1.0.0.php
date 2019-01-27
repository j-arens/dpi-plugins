<?php

/*
Plugin Name: DPI Calendar
Plugin URI: http://www.diocesan.com
Description: Display events from your Google Calendar.
Author: Josh Arens
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/vendor/autoload.php';

define( 'DPI_CAL_VERSION', '1.0.0' );

class DPI_CAL {

  private $plugin_page;
  private $shortcodes;

  public function __construct() {
    register_activation_hook( __FILE__, [$this, 'install'] );
    // $this->check_for_updates();
    $this->load_plugin();
  }

  public function install() {
    update_option( 'dpi_cal_version', DPI_CAL_VERSION );
  }

  public function check_for_updates() {
    // any version greater than 1.x.x means breaking changes - don't update, alert user
    if ( intval( get_option( 'dpi_cal_version' ) ) < 2 ) {
      Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/j-arens/dpi-cal2',
        __FILE__,
        'dpi-cal-' . DPI_CAL_VERSION
      );
    }
  }

  public function load_plugin() {
    if ( is_admin() ) {
      $this->plugin_page = new DPI_CAL_Plugin_Page();
    } else {
      $this->shortcodes = new DPI_CAL_Shortcodes();
    }
  }
}

new DPI_CAL();
