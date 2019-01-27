<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CAL_Plugin_Page {

  private $sections = [
    'general_options' => [
      'id' => 'dpi_cal_general_options',
      'title' => 'General Settings'
    ]
  ];

  private $fields = [
    'cal_id' => [
      'id' => 'dpi_cal_cal_id',
      'title' => 'Calendar ID',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'text'
    ],
    'api_key' => [
      'id' => 'dpi_cal_api_key',
      'title' => 'API Key',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'text'
    ],
    'timezone' => [
      'id' => 'dpi_cal_timezone',
      'title' => 'Timezone',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'select',
      'options' => [
        'America/New_York' => 'New York',
        'America/Chicago' => 'Chicago',
        'America/Denver' => 'Denver',
        'America/Los_Angeles' => 'Los Angeles',
        'America/Anchorage' => 'Anchorage',
        'America/Honolulu' => 'Honolulu'
      ]
    ],
    'calendar_format' => [
      'id' => 'dpi_cal_format',
      'title' => 'Calendar Format',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'select',
      'options' => [
        'month' => 'Month',
        'basicWeek' => 'Week',
        'basicDay' => 'Day',
        'agendaWeek' => 'Agenda - Week',
        'agendaDay' => 'Agenda - Day'
      ]
    ],
    'primary_color' => [
      'id' => 'dpi_cal_primary_color',
      'title' => 'Primary Color',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'color'
    ],
    'secondary_color' => [
      'id' => 'dpi_cal_secondary_color',
      'title' => 'Seconday Color',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'color'
    ],
    'text_color' => [
      'id' => 'dpi_cal_text_color',
      'title' => 'Text Color',
      'section' => 'dpi_cal_general_options',
      'input_type' => 'color'
    ]
  ];

  public function __construct() {
    add_action( 'admin_menu', [$this, 'add_page'] );
    add_action( 'admin_enqueue_scripts', [$this, 'enqueue_page_assets'] );
    add_action( 'admin_init', [$this, 'page_init'] );
  }

  public function add_page() {
    add_menu_page(
      'DPI Calendar Settings',
      'DPI Calendar',
      'manage_options',
      'dpi-cal-settings',
      [$this, 'create_page']
    );
  }

  public function enqueue_page_assets() {
    wp_register_style( 'dpi-cal-admin-css', plugins_url( '../css/plugin-page.css', __FILE__ ), '1.0.0', 'all' );
    wp_register_script( 'dpi-cal-admin-js', plugins_url( '../js/plugin-page.js', __FILE__ ), ['jquery', 'wp-color-picker'], true );
  }

  public function page_init() {
    $this->generate_sections();
    $this->generate_fields();
  }

  public function generate_sections() {
    foreach( $this->sections as $section ) {
      add_settings_section(
        $section['id'],
        $section['title'],
        [$this, 'sections_callback'],
        'dpi-cal-settings'
      );
    }
  }

  public function generate_fields() {
    foreach( $this->fields as $field ) {
      add_settings_field(
        $field['id'],
        $field['title'],
        [$this, 'fields_callback'],
        'dpi-cal-settings',
        $field['section'],
        $args = [
          'id' => $field['id'],
          'type' => $field['input_type'],
          'options' => array_key_exists( 'options', $field ) ? $field['options'] : false,
          'min' => array_key_exists( 'min', $field ) ? $field['min'] : false,
          'max' => array_key_exists( 'max', $field ) ? $field['max'] : false,
          'default' => array_key_exists( 'default', $field ) ? $field['default'] : false
        ]
      );

      register_setting(
        $field['section'],
        $field['id'],
        [$this, 'sanitize_inputs']
      );
    }
  }

  public function sections_callback( $args ) {
    settings_fields( $args['id'] );
  }

  public function fields_callback( $args ) {
    switch ( $args['type'] ) {
      case 'radio':
      case 'checkbox':
        printf(
          '<input type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" %s />',
          !empty( get_option( $args['id'] ) && get_option( $args['id'] ) == true ) ? 'checked' : ''
        );
        break;
      case 'color':
        printf(
          '<input type="text" class="dpi-cal-color" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
          !empty( get_option( $args['id'] ) ) ? get_option( $args['id'] ) : ''
        );
        break;
      case 'number':
        $min = is_numeric( $args['min'] ) ? 'min="' . $args['min'] . '"' : '';
        $max = is_numeric( $args['max'] ) ? 'max="' . $args['max'] . '"' : '';
        $value = is_numeric( $args['default'] ) && empty( get_option( $args['id'] ) ) ? $args['default'] : get_option( $args['id'] );
        echo '
          <input type="number" id="' . $args['id'] . '" name="' . $args['id'] . '" ' . $min . $max . ' value="' . $value . '" />
        ';
        break;
      case 'select':
        $selected = get_option( $args['id'] );
        $select = '<select id="' . $args['id'] . '" name="' . $args['id'] . '">';
        foreach( $args['options'] as $k => $v ) {
          $select .= '<option ' . ($selected == $k ? "selected" : "") . ' value="' . $k . '">' . $v . '</option>';
        }
        $select .= '</select>';
        print $select;
        break;
      default:
        printf(
          '<input type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
          !empty( get_option( $args['id'] ) ) ? get_option( $args['id'] ) : ''
        );
        break;
    }
  }

  public function sanitize_inputs( $dirty ) {
    $clean = '';

    if ( is_string( $dirty ) ) {
      $clean = sanitize_text_field( $dirty );
    } else if ( is_int( $dirty ) ) {
      $clean = absint( $dirty );
    }

    return $clean;
  }

  public function create_page() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'dpi-cal-admin-css' );
    wp_enqueue_script( 'dpi-cal-admin-js' );
    ?>
    <div id="dpi-cal-settings-page" class="wrap">
        <?php settings_errors() ?>
        <h1>DPI Calendar Plugin Settings</h1>
        <div id="dpi-cal-calendar"></div>
        <form method="post" action="options.php" enctype="multipart/form-data">
          <?php
            do_settings_sections( 'dpi-cal-settings' );
            submit_button();
          ?>
        </form>
      </div>
    <?php
  }
}
