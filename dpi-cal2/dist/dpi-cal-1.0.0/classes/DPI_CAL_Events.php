<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CAL_Events {

  private $settings;

  public function __construct( $settings ) {
    $this->validate_settings( $settings );
  }

  public function validate_settings( $settings ) {
    $this->settings = [
      'api_key' => !empty( get_option( 'dpi_cal_api_key' ) ) ? get_option( 'dpi_cal_api_key' ) : false,
      'id' => !empty( get_option( 'dpi_cal_cal_id' ) ) ? get_option( 'dpi_cal_cal_id' ) : false,
      'max_events' => round( absint( $settings['max_events'] ) )
    ];
  }

  public function get_events() {
    $startTime = str_replace( '+', '-', date( 'c', strtotime( 'now' ) ) );
    $endTime = str_replace( '+', '-', date( 'c', strtotime( '+1 year' ) ) );
    $url = 'https://www.googleapis.com/calendar/v3/calendars/' . $this->settings['id'] . '/events?orderBy=startTime&singleEvents=true&timeMax=' . $endTime . '&timeMin=' . $startTime . '&key=' . $this->settings['api_key'];
    $data = json_decode( file_get_contents( $url ) );
    return array_slice( $data->items, 0, $this->settings['max_events'] );
  }

  public function render_err() {
    return '
      <div id="dpi-cal-gcal-events" class="dpi-cal-error">
        Sorry, we\'re unable to retrieve your events right now. Please make sure the ID and API Key are correct.
      </div>
    ';
  }

  public function render_events() {
    if ( !$this->settings['api_key'] || !$this->settings['id'] ) {
      return $this->render_err();
    } else {
      $events = $this->get_events();
      if ( empty( $events ) ) {
        return $this->render_err();
      } else {
        $html = '<ul class="dpi-cal-events">';

        foreach( $events as $event ) {
          $date = '';
          $location = '';
          
          if ( property_exists( $event->start, 'date' ) ) {
            $date = $event->start->date;
          } else if ( property_exists( $event->start, 'dateTime' ) ) {
            $date = $event->start->dateTime;
          }

          if ( property_exists( $event, 'location' ) ) {
            $location = $event->location;
          }

          $html .= '
            <li class="dpi-cal-events-item">
              <aside class="dpi-cal-events-date">
                <span class="dpi-cal-events-day">' . date( 'd', strtotime( $date ) ) . '</span>
                <span class="dpi-cal-events-month">' . date( 'M', strtotime( $date ) ) . '</span>
              </aside>
              <a class="dpi-cal-events-link" href="' . $event->htmlLink . '" target="_blank">
                <title style="display: block" class="dpi-cal-events-title">' . wp_trim_words( $event->summary, 5, '...' ) . '</title>
                <p class="dpi-cal-events-excerpt">' . wp_trim_words( $location, 5, '...' ) . '</p>
              </a>
            </li>
          ';
        }

        $html .= '</ul>';

        return $html;
      }
    }
  }
}
