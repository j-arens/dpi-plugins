<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CC_Shortcode {

  private $formControl;

  public function __construct( $ctrl) {
    $this->formControl = $ctrl;
    add_shortcode( 'dpi_cc', [$this, 'shortcode_handler'] );
  }

  public function shortcode_handler() {
    return $this->formControl->renderRoot();
  }
}
