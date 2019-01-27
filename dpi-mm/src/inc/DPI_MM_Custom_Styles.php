<?php

// localstorage contenteditable css????

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_MM_Custom_Styles {

  /**
  * Track # of tpl's
  */
  public static function get_total_tpl( $menu_name ) {
    $tpl_item_count = 0;
    $nav_items = wp_get_nav_menu_items( $menu_name );

    foreach( $nav_items as $item ) {
      if ( $item->menu_item_parent == 0 ) {
        $tpl_item_count++;
      }
    }

    return $tpl_item_count;
  }

  /**
  * Styles output
  */
  public static function Build_Styles( $shortcode_options ) {

    $plugin_page_options = [
      'menu_name' => get_option( 'dpi_mm_menu_name' ),
      'breakpoint' => get_option( 'dpi_mm_breakpoint' ),
      'max_width' => get_option( 'dpi_mm_max_width' ),
      'nav_bg_dk' => get_option( 'dpi_mm_nav_bg_dk' ),
      'nav_bg_mb' => get_option( 'dpi_mm_nav_bg_mb' ),
      'tpl_title_button_mb_bg' => get_option( 'dpi_mm_tpl_btn_mobile_bg' ),
      'sub_menu_bg_dk' => get_option( 'dpi_mm_sub_menu_bg_dk' ),
      'sub_menu_bg_mb' => get_option( 'dpi_mm_sub_menu_bg_mb' ),
      'tpl_title_color' => get_option( 'dpi_mm_tpl_title_color' ),
      'tpl_title_hover_color' => get_option( 'dpi_mm_tpl_title_hover_color' ),
      'sub_menu_title_color_dk' => get_option( 'dpi_mm_sub_menu_title_color_dk' ),
      'sub_menu_title_color_mb' => get_option( 'dpi_mm_sub_menu_title_color_mb' ),
      'sub_menu_link_color_dk' => get_option( 'dpi_mm_sub_menu_link_color_dk' ),
      'sub_menu_link_color_hover_dk' => get_option( 'dpi_mm_sub_menu_link_color_hover_dk' ),
      'sub_menu_link_color_mb' => get_option( 'dpi_mm_sub_menu_link_color_mb' ),
      'sub_menu_link_color_hover_mb' => get_option( 'dpi_mm_sub_menu_link_color_hover_mb' ),
      'tpl_title_font_size_dk' => get_option( 'dpi_mm_tpl_link_font_size_dk' ),
      'tpl_title_font_size_mb' => get_option( 'dpi_mm_tpl_link_font_size_mb' ),
      'sub_menu_title_font_size_dk' => get_option( 'dpi_mm_sub_menu_title_font_size_dk' ),
      'sub_menu_title_font_size_mb' => get_option( 'dpi_mm_sub_menu_title_font_size_mb' ),
      'sub_menu_link_font_size_dk' => get_option( 'dpi_mm_sub_menu_link_color_dk' ),
      'sub_menu_link_font_size_mb' => get_option( 'dpi_mm_sub_menu_link_font_size_mb' )
    ];

    $options = array_merge( $plugin_page_options, $shortcode_options );

    $custom_styles = '
      <style id="dpi-mm-editable-styles" contenteditable draggable="true">

      /**
      * Desktop styles
      */

      /** Container nav styles **/

      #dpi-mega-menu {
        background: #4AA0D5; /* <- Main Nav background color */
        margin: 0 auto;
        width: 100%;
        position: relative;
      }

      #dpi-mega-menu li {
        list-style: none;
      }

      #dpi-mega-menu a {
        text-decoration: none;
      }

      #dpi-mega-menu a[href^="http"]:empty::before {
        content: attr(href);
      }

      #dpi-mega-menu a[href^="www"]:empty::before {
        content: attr(href);
      }

      /** Mobile toggle **/

      .mobile-toggle {
        display: none;
        width: 4em;
        height: 4em;
        background: white;
        box-shadow: 0 0 20px 2px rgba(0, 0, 0, 0.2);
        position: fixed;
        top: 0;
        left: 0;
        cursor: pointer;
      }

      .mobile-toggle p {
        display: block;
        margin-top: .5em;
        text-align: center;
      }

      .mobile-toggle p::before {
        content: "Menu";
      }

      .mobile-toggle p::after {
        content: "Close";
        display: none;
      }

      .hamburger {
        display: block;
        width: 2.25em;
        height: 2px;
        background: black;
        position: relative;
        margin: 1em auto 0 auto;
      }

      .hamburger::before,
      .hamburger::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        background: black;
      }

      .hamburger::before {
        top: -.5em;
      }

      .hamburger::after {
        bottom: -.5em;
      }

      /** Top level menu container styles **/

      #menu-primary-menu {
        display: table;
        position: relative;
        background: transparent; /* <- Top level menu background color */
        margin: 0 auto;
        width: 100%;
        max-width: 62.5em; /* <- Top level menu width */
        zoom: 1;
      }

      .tpl {
        display: table-cell;
        width: calc(100% / ' . self::get_total_tpl( $options['menu_name'] ) . '); /* <- Denominator calc\'d on server */
        padding: 1em 0;
      }

      .tpl:hover .tpl-title{
        color: #454553; /* <- Top level menu title color on hover */
      }

      /** Top level menu title styles **/

      .tpl-title {
        font-family: inherit; /* <- Top level menu title font family */
        font-weight: 400; /* <- Top level menu title font weight */
        font-style: normal; /* <- Top level menu title font style */
        user-select: none;
        display: inline-block;
        position: relative;
        z-index: 9999;
        margin-left: 50%;
        transform: translateX(-50%);
        text-decoration: none;
        cursor: pointer;
        font-size: 1.5em; /* <- Top level menu title font size */
        color: #fff; /* <- Top level menu title color */
      }

      .tpl-title::after {
        content: "";
        background: #fff; /* <- down arrow container background color */
        display: none;
        position: absolute;
        top: 158%;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 998;
        width: 1em;
        height: 1em;
      }

      .tpl-title svg {
        display: none;
        position: absolute;
        width: 1.25em;
        height: 1.25em;
        top: 147%;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 999;
        fill: #23232B;/* <- down arrow color */
      }

      /** Desktop active styles **/

      .tpl-active .tpl-title::after,
      .tpl-active svg,
      .tpl-active .sub-container {
        display: block;
      }

      .tpl-active .tpl-title {
        color: #23232B; /* <- Top level menu title color on active */
      }

      .tpl-active:hover .tpl-title {
        color: #23232B; /* <- Matches color above to override previous hover */
      }

      /** Sub menu styles **/

      .sub-container {
        display: none;
        position: absolute;
        z-index: 999;
        top: 100%;
        left: 0;
        width: 100%;
        background: #eee; /* <- Sub menu countainer background */
        padding: 2em 2em 1em 2em;
        font-size: 1rem;
      }

      .sub-container::after {
        content: "";
        display: table;
        clear: both;
      }

      .sub-list {
        display: table;
      }

      .sub-list > li {
        display: table-cell;
        float: left;
        padding: 0 2em;
        min-width: 230px;
        margin-bottom: 2em;
      }

      .menu-title {
        font-family: inherit; /* <- Sub menu title font family */
        font-weight: 400; /* <- Sub menu title font weight */
        font-style: normal; /* <- Sub menu title font style */
        display: inline-block;
        color: #616170; /* <- Sub menu title color */
        font-size: 1.25em; /* <- Sub menu title font size */
        margin-bottom: .5em; /* <- Sub menu title margin */
      }

      .sub-list a {
        font-family: inherit; /* <- Sub menu link font family */
        font-weight: 400; /* <- Sub menu link font weight */
        font-style: normal; /* <- Sub menu link font style */
        color: #616170; /* <- Sub menu link color */
        font-size: 1em; /* <- Sub menu link font size */
        line-height: 1em; /* match font size above */
      }

      .sub-list a:hover {
        color: #EB586F; /* <- Sub link color on hover */
      }

      /**
      * Mobile styles
      */

      @media screen and (max-width: 550px) { /* <- breakpoint */

        /** Container nav styles **/

        #dpi-mega-menu {
          background: #eee; /* <- Main nav background color */
        }

        /** Mobile toggle **/

        .mobile-toggle {
          display: block;
        }

        #dpi-mega-menu.active #menu-primary-menu {
          display: table;
        }

        #dpi-mega-menu.active .mobile-toggle {
          position: relative;
          width: 100%;
          background: #eee;
          box-shadow: none;
          height: 3.5em;
        }

        #dpi-mega-menu.active .mobile-toggle p::before {
          display: none;
        }

        #dpi-mega-menu.active .mobile-toggle p::after {
          display: block;
        }

        #dpi-mega-menu.active .hamburger {
          background: transparent;
          margin-top: 1.5em;
        }

        #dpi-mega-menu.active .hamburger::before,
        #dpi-mega-menu.active .hamburger::after {
          top: auto;
          bottom: auto;
        }

        #dpi-mega-menu.active .hamburger::before {
          transform: rotate(45deg);
        }

        #dpi-mega-menu.active .hamburger::after {
          transform: rotate(-45deg);
        }

        /** Top level menu container styles **/

        #menu-primary-menu {
          display: none;
          padding: .5em;
          background: #eee; /* <- Top level menu background color */
        }

        .tpl {
          display: block;
          position: relative;
          z-index: 100;
          width: 100% !important;
          background: lightskyblue; /* <- Top level menu button background */
          padding: 0;
        }

        .tpl:not(:first-child) {
          margin: .5em 0; /* <- button spacing */
        }

        .tpl-title {
          display: inline-block;
          width: 100%;
          height: 100%;
          padding: 1em 0;
          font-size: 1.5em; /* <- Top level menu title font size */
          text-align: center;
          margin: 0;
          transform: initial;
        }

        .tpl-active .tpl-title::after,
        .tpl-active svg {
          display: none;
        }

        .tpl-active .tpl-title .sub-container {
          display: block;
        }

        /** Sub menu styles **/

        .sub-container {
          display: none;
          position: relative;
          width: 100%;
          background: #eee;
          padding: 1em;
        }

        .sub-list {
          padding-top: .5em;
        }

        .sub-list > li {
          display: block;
          width: 100%;
          float: none;
          padding: 0 1em;
        }

        .sub-list > li:last-child {
          margin-bottom: 0;
        }

        .menu-title {
          font-size: 1.75em; /* <- Sub menu title font size */
        }

        .sub-list a {
          font-size: 1.25em; /* <- Sub menu link font size */
          line-height: 1.5em; /* <- match font size above */
        }
      }

      </style>
    ';

    return $custom_styles;

  }
}
