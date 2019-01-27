<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_MM_Options_Page {

  public $fields;
  public $sections;

  public function __construct() {

    // add plugin page
    add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );

    // enqueue plugin page styles
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

    // page and settings output
    add_action( 'admin_init', [ $this, 'page_init' ] );

    $this->sections = [
      'general_options' => [
        'id' => 'general_options_section',
        'title' =>  'General Settings'
      ],
      'background_color_options' => [
        'id' => 'background_colors_options_section',
        'title' =>  'Background Colors'
      ],
      'title_colors_options' => [
        'id' => 'title_colors_options_section',
        'title' =>  'Title Colors'
      ],
      'link_colors_options' => [
        'id' => 'link_colors_options_section',
        'title' =>  'Link Colors'
      ],
      'font_size_options' => [
        'id' => 'font_sizes_options_section',
        'title' =>  'Font Sizes'
      ]
    ];

    $this->fields = [
      'menu_name' => [
        'id' => 'dpi_mm_menu_name',
        'title' => 'Menu Name',
        'section' => 'general_options_section'
      ],
      'breakpoint' => [
        'id' => 'dpi_mm_breakpoint',
        'title' => 'Breakpoint',
        'section' => 'general_options_section'
      ],
      'max_width' => [
        'id' => 'dpi_mm_max_width',
        'title' => 'Max Width',
        'section' => 'general_options_section'
      ],
      'desktop_nav_bg' => [
        'id' => 'dpi_mm_nav_bg_dk',
        'title' => 'Desktop Nav Background',
        'section' => 'background_colors_options_section'
      ],
      'mobile_nav_bg' => [
        'id' => 'dpi_mm_nav_bg_mb',
        'title' => 'Mobile Nav Background',
        'section' => 'background_colors_options_section'
      ],
      'tpl_link_color' => [
        'id' => 'dpi_mm_tpl_title_color',
        'title' => 'Top Level Title Color',
        'section' => 'title_colors_options_section'
      ],
      'tpl_link_hover_color' => [
        'id' => 'dpi_mm_tpl_title_hover_color',
        'title' => 'Top Level Title Hover Color',
        'section' => 'title_colors_options_section'
      ],
      'tpl_link_font_size_dk' => [
        'id' => 'dpi_mm_tpl_link_font_size_dk',
        'title' => 'Top Level Link Desktop Font Size',
        'section' => 'font_sizes_options_section'
      ],
      'tpl_link_font_size_mb' => [
        'id' => 'dpi_mm_tpl_link_font_size_mb',
        'title'=> 'Top Level Link Mobile Font Size',
        'section' => 'font_sizes_options_section'
      ],
      'tpl_btn_mobile_bg' => [
        'id' => 'dpi_mm_tpl_btn_mobile_bg',
        'title' => 'Top Level Link Mobile Button Background',
        'section' => 'background_colors_options_section'
      ],
      'sub_menu_bg_dk' => [
        'id' => 'dpi_mm_sub_menu_bg_dk',
        'title' => 'Sub Menu Desktop Background',
        'section' => 'background_colors_options_section'
      ],
      'sub_menu_bg_mb' => [
        'id' => 'dpi_mm_sub_menu_bg_mb',
        'title' => 'Sub Menu Mobile Background',
        'section' => 'background_colors_options_section'
      ],
      'sub_menu_title_font_size_dk' => [
        'id' => 'dpi_mm_sub_menu_title_font_size_dk',
        'title' => 'Sub Menu Desktop Title Font Size',
        'section' => 'font_sizes_options_section'
      ],
      'sub_menu_title_font_size_mb' => [
        'id' => 'dpi_mm_sub_menu_title_font_size_mb',
        'title' => 'Sub Menu Mobile Title Font Size',
        'section' => 'font_sizes_options_section'
      ],
      'sub_menu_title_color_dk' => [
        'id' => 'dpi_mm_sub_menu_title_color_dk',
        'title' => 'Sub Menu Desktop Title Color',
        'section' => 'title_colors_options_section'
      ],
      'sub_menu_title_color_mb' => [
        'id' => 'dpi_mm_sub_menu_title_color_mb',
        'title' => 'Sub Menu Mobile Title Color',
        'section' => 'title_colors_options_section'
      ],
      'sub_menu_link_font_size_dk' => [
        'id' => 'dpi_mm_sub_menu_link_font_size_dk',
        'title' => 'Sub Menu Desktop Link Font Size',
        'section' => 'font_sizes_options_section'
      ],
      'sub_menu_link_font_size_mb' => [
        'id' => 'dpi_mm_sub_menu_link_font_size_mb',
        'title' => 'Sub Menu Mobile Link Font Size',
        'section' => 'font_sizes_options_section'
      ],
      'sub_menu_link_color_dk' => [
        'id' => 'dpi_mm_sub_menu_link_color_dk',
        'title' => 'Sub Menu Desktop Link Color',
        'section' => 'link_colors_options_section'
      ],
      'sub_menu_link_color_hover_dk' => [
        'id' => 'dpi_mm_sub_menu_link_color_hover_dk',
        'title' => 'Sub Menu Desktop Link Hover Color',
        'section' => 'link_colors_options_section'
      ],
      'sub_menu_link_color_mb' => [
        'id' => 'dpi_mm_sub_menu_link_color_mb',
        'title' => 'Sub Menu Mobile Link Color',
        'section' => 'link_colors_options_section'
      ],
      'sub_menu_link_color_hover_mb' => [
        'id' => 'dpi_mm_sub_menu_link_color_hover_mb',
        'title' => 'Sub Menu Mobile Link Hover Color',
        'section' => 'link_colors_options_section'
      ]
    ];
  }

  /**
  * Enqueue admin page assets
  */
  public function enqueue_admin_assets() {

    // styles for plugin settings page
    wp_register_style( 'dpi_mm_plugin_page_styles', plugin_dir_url( __FILE__ ) . '../assets/css/admin-styles.css', '1.0.0', 'all' );
    wp_enqueue_style( 'dpi_mm_plugin_page_styles' );
  }

  /**
  * Add plugin page
  */
  public function add_plugin_page() {

    // page settings
    add_plugins_page(
      'DPI Mega Menu Settings',
      'DPI Mega Menu',
      'manage_options',
      'dpi-mm-settings',
      [ $this, 'create_page' ]
    );
  }

  /**
  * Page callback
  */
  public function create_page() {
    ?>
      <div id="dpi_mm_settings_page" class="wrap">
        <?php settings_errors(); ?>
        <h1>DPI Mega Menu</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
          <?php

            do_settings_sections( 'dpi-mm-settings' );

            submit_button();

          ?>
        </form>
      </div>
    <?php
  }

  /**
  * Page init
  */
  public function page_init() {
    $this->generate_sections( $this->sections );
    $this->generate_fields( $this->fields );
  }

  /**
  * Generate setting sections
  */
  public function generate_sections( $sections ) {
    foreach( $sections as $section ) {
      add_settings_section(
        $section['id'],
        $section['title'],
        [ $this, 'sections_callback' ],
        'dpi-mm-settings'
      );
    }
  }

  /**
  * Generate fields
  */
  public function generate_fields( $fields ) {
    foreach( $fields as $field ) {
      add_settings_field(
        $field['id'],
        $field['title'],
        [ $this, 'field_callback' ],
        'dpi-mm-settings',
        $field['section'],
        $args = $field['id']
      );

      register_setting(
        $field['section'],
        $field['id'],
        [ $this, 'dpi_mm_sanitize' ]
      );
    }
  }

  public function sections_callback( $args ) {
    settings_fields( $args['id'] );
  }

  /**
  * Field callbacks
  */
  public function field_callback( $id ) {
    printf(
      '<input type="text" id="' . $id . '" name="' . $id . '" value="%s" />',
      !empty( get_option( $id ) ) ? get_option( $id ) : ''
    );
  }

  /**
  * Print settings section header
  */
  public function print_errors() {
    // settings_errors();
  }

  /**
  * Sanitize and validate callback
  */
  public function dpi_mm_sanitize( $input ) {
    $new_input = '';

    print 'sanitize';

    // sanitize strings and make integers non-negative
    if ( is_string( $input ) ) {
      $new_input = sanitize_text_field( $input );
    } else if ( is_int( $input ) ) {
      $new_input = absint( $input );
    }

    return $new_input;
  }

}
