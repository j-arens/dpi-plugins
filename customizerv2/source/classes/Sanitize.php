<?php

class Sanitize {

  public function register_callback() {
    return [$this, 'sanitize_setting'];
  }

  public function sanitize_setting( $dirty ) {
    switch ( gettype( $dirty ) ) {
      case 'string':
        return sanitize_text_field( $dirty );
      case 'float':
      case 'integer':
      case 'numeric':
        return filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT );
      case 'boolean':
        $bool = sanitize_text_field( $dirty );
        if ( $bool === 'true' || $bool === 'false' ) {
          return $bool;
        } else {
          return new WP_Error( 'Customizer Sanitize', __( 'Unable to sanitize setting: ' . $dirty ) );
        }
      default:
        return new WP_Error( 'Customizer Sanitize', __( 'Unable to sanitize setting: ' . $dirty ) );
    }
  }
}
