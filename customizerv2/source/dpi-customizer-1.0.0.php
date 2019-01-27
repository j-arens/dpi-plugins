<?php

define( 'DPI_CUSTOMIZER_VERSION', '1.0.0' );

class DPI_Customizer_Init {

  private $plugin_page;
  private $customizer;

  public function __construct() {
    register_activation_hook( __FILE__, [$this, 'install'] );
    $this->check_for_updates();
    $this->load_plugin();
  }

  public function install() {

  }

  public function check_for_updates() {
    if ( intval( get_option( 'dpi_bulletins_version' ) ) < 2 ) {
      Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/j-arens/dpi-customizer',
        __FILE__,
        'dpi-customizer-' . DPI_BULLETINS_VERSION
      );
    }
  }

  public function load_plugin() {
    if ( is_admin() ) {
      $this->plugin_page = new Plugin_Page();
    } else if ( is_customize_preview() ) {
      $this->customizer = new Customizer();
    }
  }

}

new DPI_Customizer_Init();
