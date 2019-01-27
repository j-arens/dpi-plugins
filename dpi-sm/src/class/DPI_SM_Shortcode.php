<?php

// namespace DPI_SM\DPI_SM_Shortcode;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// use DPI_SM\DPI_SM_Nav;
require_once( DPI_SM_DIR . '/class/DPI_SM_Nav.php' );

class DPI_SM_Shortcode {

  public function __construct() {
    add_shortcode( 'dpi_super_menu', [$this, 'shortcode_cb'] );
  }

  public function shortcode_cb( $atts ) {
    $args = shortcode_atts([
      'breakpoint' => 1000
    ], $atts);
    return new DPI_SM_Nav( $args );
  }
}
