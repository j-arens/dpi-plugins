<?php

class DPI_Staff_Backend {

  public function __construct() {
    add_action( 'media_buttons', [ $this, 'add_staff_button' ], 15 );
    add_action( 'in_admin_footer', [ $this, 'load_assets' ] );
  }

  public function add_staff_button() {
    $button = '
      <a href="#" id="dpi-staff" class="button">
        <span
          class="wp-media-buttons-icon"
          style="background: url("/wp-content/plugins/dpi-staff/assets/icons/account-add.svg");
                 background-repeat: no-repeat;
                 background-position: left bottom;">
         </span>
        Add Staff
      </a>'
    ;
    echo $button;
  }

  public function load_assets() {
    wp_register_script( 'dpi-staff', DPI_STAFF_DIR . '/assets/js/app.js', null, '1.0.0' );
    wp_enqueue_script( 'dpi-staff' );
  }
}
