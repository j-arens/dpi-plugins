<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CAL_Calendar {

  private $settings;

  public function __construct( $settings ) {
    $this->validate_settings( $settings );
  }

  public function validate_settings( $settings ) {
    $this->settings = [
      'api_key' => !empty( get_option( 'dpi_cal_api_key' ) ) ? get_option( 'dpi_cal_api_key' ) : false,
      'id' => !empty( get_option( 'dpi_cal_cal_id' ) ) ? get_option( 'dpi_cal_cal_id' ) : false,
      'primary_color' => !empty( get_option( 'dpi_cal_primary_color' ) ) ? get_option( 'dpi_cal_primary_color' ) : '#FFE3E3',
      'secondary_color' => !empty( get_option( 'dpi_cal_secondary_color' ) ) ? get_option( 'dpi_cal_secondary_color' ) : '#ff3b30',
      'text_color' => !empty( get_option( 'dpi_cal_text_color' ) ) ? get_option( 'dpi_cal_text_color' ) : '#000',
      'format' => !empty( $settings['format'] ) ? sanitize_text_field( $settings['format'] ) : get_option( 'dpi_cal_format', 'month' ),
      'timezone' => !empty( get_option( 'dpi_cal_timezone' ) ) ? get_option( 'dpi_cal_timezone' ) : 'America/Chicago'
    ];
  }

  public function load_assets() {
    // register first so we can localize
    wp_register_script( 'dpi-cal-init', plugins_url( '../js/cal-init.js', __FILE__ ), ['jquery'], '1.0.2', true );

    wp_localize_script(
      'dpi-cal-init',
      'dpi_cal_localized',
      [
        'key' => base64_encode( $this->settings['api_key'] ),
        'id' => base64_encode( $this->settings['id'] ),
        'format' => $this->settings['format'],
        'timezone' => $this->settings['timezone'],
        'primary_color' => $this->settings['primary_color'],
        'secondary_color' => $this->settings['secondary_color'],
        'text_color' => $this->settings['text_color']
      ]
    );

    wp_enqueue_script( 'dpi-cal-moment', plugins_url( '../js/vendor/moment.min.js', __FILE__ ), null, '1.0.2', true );
    wp_enqueue_script('dpi-cal-moment-tz', plugins_url('../js/vendor/moment-tz.min.js', __FILE__), ['dpi-cal-moment'], '1.0.0', true);
    wp_enqueue_script( 'dpi-cal-full-calendar', plugins_url( '../js/vendor/fullcalendar.js', __FILE__ ), ['jquery', 'dpi-cal-moment', 'dpi-cal-moment-tz'], '1.0.2', true );
    wp_enqueue_script( 'dpi-cal-gcal', plugins_url( '../js/vendor/gcal.js', __FILE__ ), null, '1.0.2', true );
    wp_enqueue_script( 'dpi-cal-init' );
    wp_enqueue_style( 'dpi-cal-styles', plugins_url( '../css/vendor/fullcalendar.css', __FILE__ ), '1.0.2', 'screen' );
  }

  public function render_err() {
    wp_enqueue_style( 'dpi-cal-error-css', plugins_url( '../css/dpi-cal-error.css', __FILE__ ), '1.0.2', 'screen' );
    return '
      <div id="dpi-cal-calendar" class="dpi-cal-error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        <p>Sorry, we\'re unable to retrieve your calendar right now. Please make sure the ID and API Key are correct.</p>
      </div>
    ';
  }

  public function render_root() {
    if ( $this->settings['api_key'] && $this->settings['id'] ) {
      $this->load_assets();
      return '
        <div id="dpi-cal-calendar"></div>
      ';
    } else {
      return $this->render_err();
    }
  }
}
