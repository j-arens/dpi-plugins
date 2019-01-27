<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

include( 'DPI_MM_Walker.php' );
include( 'DPI_MM_Custom_Styles.php' );

class DPI_MM_Nav {

  /**
  * Nav output
  */
  public static function Build_Nav( $options ) {

    $nav_begin = '<nav id="dpi-mega-menu">';

    $mobile_toggle = '
    <div class="mobile-toggle">
      <p></p>
      <span class="hamburger"></span>
    </div>
    ';

    $nav_end = '</nav>';

    $output = wp_nav_menu([
      'container' => '',
      'container_class' => '',
      'container_id' => '',
      'echo' => false,
      'menu' => $options['menu_name'],
      'menu_class' => '',
      'depth' => '3',
      'walker' => new DPI_MM_Walker( $options['menu_name'] )
    ]);

    $custom_styles = DPI_MM_Custom_Styles::Build_Styles( $options );

    return $custom_styles . $nav_begin . $mobile_toggle . $output . $nav_end;
  }
}
