<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CAL_Shortcodes {

  public function __construct() {
    add_shortcode( 'dpi_calendar', [$this, 'calendar_shortcode'] );
    add_shortcode( 'dpi_gcal_events', [$this, 'events_shortcode'] );
  }

  public function calendar_shortcode( $atts ) {
    $args = shortcode_atts([
      'format' => ''
    ], $atts);

    $calendar = new DPI_CAL_Calendar( $args );
    return $calendar->render_root();
  }

  public function events_shortcode( $atts ) {
    $args = shortcode_atts([
      'max_events' => 4
    ], $atts);

    $events_list = new DPI_CAL_Events( $args );
    return $events_list->render_events();
  }
}
