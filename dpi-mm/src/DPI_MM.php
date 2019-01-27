<?php

/*
Plugin Name: DPI Mega Menu
Plugin URI: http://www.diocesan.com
Description: Taking your site navigation to the next level.
Author: Diocesan Publications
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

include( '/inc/DPI_MM_Shortcode.php' );
include( '/inc/DPI_MM_Options_Page.php' );

class DPI_MM {

  public function __construct() {

    // only run code for nav on front end
    if ( !is_admin() ) {
      add_action( 'wp_enqueue_scripts', [$this, 'enqueue_nav_assets'] );
      $shortcode = new DPI_MM_Shortcode();
    }

    // if coming from backend run code for options page
    if ( is_admin() ) {
      $options_page = new DPI_MM_Options_Page();
    }
  }

  public function enqueue_nav_assets() {

    // js
    wp_register_script( 'dpi-mm-control', plugin_dir_url( __FILE__ ) . '/assets/js/bundle.js', ['jquery'], true );
    wp_enqueue_script( 'dpi-mm-control' );

    // css
    wp_register_style( 'dpi-mm-styles', plugin_dir_url( __FILE__ ) . '/assets/css/mm-nav.css', '1.0.0', 'all' );
    wp_enqueue_style( 'dpi-mm-styles' );
  }
}

$DPI_Mega_Menu = new DPI_MM();
