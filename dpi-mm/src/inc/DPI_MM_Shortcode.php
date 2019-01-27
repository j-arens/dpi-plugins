<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

include( 'DPI_MM_Nav.php' );

class DPI_MM_Shortcode {

  public function __construct() {
    add_shortcode( 'dpi_mega_menu', [$this, 'shortcode_handler'] );
  }

  public function shortcode_handler( $atts ) {
    $args = shortcode_atts(
      [
        'menu_name' => 'Primary-menu',
        'breakpoint' => 550,
        'nav_width' => 1280,
        'nav_bg_desktop' => '#fff',
        'nav_bg_mobile' => '#ccc',
        'sub_menu_bg_desktop' => '#eee',
        'sub_menu_bg_mobile' => '#eee',
        'sub_menu_title_color' => '#000',
        'sub_menu_title_font_size_desktop' => '1.25em',
        'sub_menu_title_font_size_mobile' => '1.75em',
        'sub_menu_link_color' => 'grey',
        'sub_menu_link_font_size_desktop' => '1em',
        'sub_menu_link_font_size_mobile' => '1.25em',
        'sub_menu_link_hover_color' => 'cornflowerblue',
        'tpl_color' => '#000',
        'tpl_hover_color' => 'cornflowerblue',
        'tpl_font_size' => '1.5em',
        'tpl_button_bg_mobile' => 'lightskyblue'
      ], $atts );

      return DPI_MM_Nav::Build_Nav( $args );
  }

}
