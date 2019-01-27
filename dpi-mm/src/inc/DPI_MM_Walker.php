<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_MM_Walker extends \Walker_Nav_Menu {

  // opening tags for sub menus
  public function start_lvl( &$output, $depth = 0, $args = Array() ) {

    if ( $depth === 0 ) {
      $html = '
        <div class="sub-container">
          <ul class="sub-list">
      ';
    } else if ( $depth === 1 ) {
      $html = '<ul>';
    }

    $output .= $html;
  }

  // closing tags for sub menus
  public function end_lvl( &$output, $depth = 0, $args = Array() ) {

    if ( $depth === 0 ) {
      $html = '</ul></div>';
    } else if ( $depth === 1 ) {
      $html = '</ul>';
    }

    $output .= $html;
  }

  // opening tags for menu elements
  public function start_el( &$output, $item, $depth = 0 , $args = Array(), $id = 0 ) {

    if ( $depth === 0 ) {
      $html = '
        <li class="tpl">
          <span class="tpl-title">
            ' . $item->post_title . '
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"/></svg>
          </span>
      ';
    } else if ( $depth === 1 ) {
      $html = '
        <li>
          <span class="menu-title">' . $item->post_title . '</span>
      ';
    } else if ( $depth === 2 ) {
      $html = '
        <li>
          <a href="' . $item->url . '">' . $item->title . '</a>
      ';
    }

    $item_output = $html;
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  // closing tags for menu elements
  public function end_el( &$output, $item, $depth = 0, $args = Array(), $id = 0 ) {

      $html = '</li>';

    $output .= $html;
  }
}
