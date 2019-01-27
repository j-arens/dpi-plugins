<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CC_Form_Control {

  public function __construct() {
    add_action( 'wp_ajax_dpi_cc_submit', [$this, 'ajax_handler'] );
    add_action( 'wp_ajax_nopriv_dpi_cc_submit', [$this, 'ajax_handler'] );
  }

  public function submit_to_cc( $addr ) {
    $url = 'https://api.constantcontact.com/v2/contacts?action_by=ACTION_BY_OWNER&api_key=yttqzt5hmkbzmaqyfjdkezfk';

    $res = wp_remote_post( $url, [
      'method' => 'POST',
      'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . get_option( 'dpi_cc_access_token' )
      ],
      'body' => json_encode([
        'email_addresses' => [
          ['email_address' => $addr]
        ],
        'lists' => [
          ['id' => get_option( 'dpi_cc_list' )]
        ]
      ])
    ] );

    if ( is_wp_error( $res ) ) {
      return false;
    }

    return true;
  }

  public function validate_request() {
    if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'dpi_cc_nonce' ) && isset( $_POST['dpi_cc_email'] ) ) {
      return $this->submit_to_cc( $_POST['dpi_cc_email'] );
    }

    return false;
  }

  public function ajax_handler() {
    if ( $this->validate_request()) {
      status_header(200);
      wp_send_json_success(['dpi_cc_submit' => true]);
    } else {
      status_header(400);
      wp_send_json_error(['dpi_cc_submit' => false]);
    }
    wp_die();
  }

  public function load_assets() {
    wp_register_script( 'dpi-cc-form-control-js', plugins_url( '../js/main.js',  __FILE__ ), null, '1.0.0', true );
    wp_localize_script( 'dpi-cc-form-control-js', 'dpi_cc_local', ['ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'dpi_cc_nonce' )] );
    wp_enqueue_script( 'dpi-cc-form-control-js' );
  }

  public function renderRoot() {
    $this->load_assets();
    return '<input id="dpi-cc-form-root" type="hidden"></input>';
  }
}
