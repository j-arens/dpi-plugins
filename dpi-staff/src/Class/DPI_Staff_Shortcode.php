<?php

class DPI_Staff_Shortcode {

  public function __construct() {
    add_shortcode( 'dpi_staff', [ $this, 'shortcode_handler' ] );
  }

  public static function sanitize_atts( $dirty ) {
    $clean = array();
    foreach( $dirty as $k => $v ) {
      if ( is_string( $v ) ) {
        $clean[$k] = sanitize_text_field( $v );
      } else if ( is_numeric( $v ) ) {
        $clean[$k] = abs( $v );
      }
    }
    return $clean;
  }

  public function shortcode_handler( $atts ) {
    $args = shortcode_atts([
      'img_id' => '',
      'name' => '',
      'position' => '',
      'email' => '',
      'phone' => '',
      'img_size' => 'medium'
    ], $atts );

    $data = self::sanitize_atts( $args );
    $img_url = wp_get_attachment_image_url( $data['img_id'], $data['img_size'] );

    $template = '
      <div class="dpi-staff-member">
        <section class="dpi-staff-photo">
          <div class="dpi-staff-img" style="background-image: url(' . $img_url . ')"></div>
        </section>
        <section class="dpi-staff-info">
          <p class="dpi-staff-name">' . $data['name'] . '</p>
          <p class="dpi-staff-position">' . $data['position'] . '</p>
          <a class="dpi-staff-email" href="mailto:' . $data['email'] . '">' . $data['email'] . '</a>
          <a class="dpi-staff-phone" href="tel:' . $data['phone'] . '">' . $data['phone'] . '</a>
        </section>
      </div>
    ';

    return $template;
  }
}
