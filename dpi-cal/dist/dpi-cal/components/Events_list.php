<?php

/*
This file outputs the events via shortcode [dpi_events].

Shortcode attributes are optional:
  - quantity = the amount of events you want, default is 8.
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Events_List {

  /**
  * Constructor
  */
  public function __construct( $plugin_dir_url ) {

    $this->plugin_dir_url = $plugin_dir_url;

    // add shortcode
    add_shortcode( 'dpi_events', [ $this, 'dpi_events_shortcode' ] );
  }

  /**
  * Shortcode handler
  */
  public function dpi_events_shortcode( $atts ) {
    $html = '';
    $args = shortcode_atts(
      array(
        'quantity' => 8,
      ), $atts );

      // get cal events
      $events = $this->get_events( array(
        'client_email' => get_option( 'dpi_cal_cal_id' ),
        'api_key' => get_option( 'dpi_cal_api_key' ),
        'event_vol' => absint( intval( $args['quantity'] ) )
      ) );

      if ( !empty( $events ) ) {
        // loop through events and output formatted html
        $html = '<ul id="dpi-cal-events">';

        foreach ( $events as $event ) {

          $html .= '
            <li class="dpi-cal-event-item">
              <a target="_blank" href="' . $event['link'] . '">
                <p>' . $event['start'] . '</p>
                <p class="dpi-cal-event-title">' . $event['summary'] . '</p>
              </a>
            </li>
          ';

        }
        $html .= '</ul>';
      } else {
        $html = '<div class="dpi-cal-no-events"><p>Sorry, there are no events to show you right now.</p></div>';
      }


      return $html;
  }

  /**
  * Get events
  */
  public function get_events( $atts ) {

    // default params
    $default_params = array(
      'client_email' => false,
      'api_key' => false,
      'event_vol' => get_option( 'dpi_cal_event_quantity', 8 ),
    );

    // merge $atts and $default_params
    $settings = array_merge( $default_params, $atts );

    // make sure we have everything we need
    if ( !empty( $settings['client_email'] ) && !empty( $settings['api_key'] ) ) {

      // now
      $startTime = str_replace( '+', '-', date( 'c', strtotime( 'now' ) ) );

      // now +1 year
      $endTime = str_replace( '+', '-', date( 'c', strtotime( '+1 year' ) ) );

      // api endpoint
      $url = 'https://www.googleapis.com/calendar/v3/calendars/' . $settings['client_email'] . '/events?orderBy=startTime&singleEvents=true&timeMax=' . $endTime . '&timeMin=' . $startTime . '&key=' . $settings['api_key'];

      // store response
      $data = json_decode( file_get_contents( $url ) );

      // loop through data and format info into array
      $current_events = [];
      $counter = 0;
      foreach( $data->items as $event ) {

        // return only a certain amount of events
        if ( $counter < $settings['event_vol'] ) {

          $current_events['event_' . $counter] = [
            'link' => $event->htmlLink,
            'summary' => $event->summary,
            // 'description' => $event->description,
            'start' => empty( $event->start->dateTime ) === true ? '' : date('m-d-Y', strtotime($event->start->dateTime)),
            // 'end' => strtotime($event->end->dateTime),
            // 'organizer_email' => $event->organizer->email,
            // 'organizer_name' => $event->organizer->displayName,
            // 'creator_email' => $event->creator->email,
            // 'creator_name' => $event->creator->displayName,
            // 'etag' => $event->etag,
            // 'id' => $event->id,
            // 'status' => $event->status,
            // 'created' => date('m-d-Y', strtotime($event->created)),
            // 'updated' => strtotime($event->updated),
          ];
          $counter++;
        }
      }
      return $current_events;
    }
  }
}
