<?php

class Validate {

  public function register_callback() {
    return [$this, 'validate_setting'];
  }

  public function validate_setting( $dirty ) {
    
  }
}
