<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_CC_Plugin_Page {

  private $key = '?api_key=yttqzt5hmkbzmaqyfjdkezfk';
  private $base_endpoint = 'https://api.constantcontact.com/v2/';

  private $sections = [
    'general_options' => [
      'id' => 'dpi_cc_general_options',
      'title' => 'General Settings'
    ]
  ];

  private $fields = [
    'registered' => [
      'new_token' => [
        'id' => 'dpi_cc_new_token',
        'title' => 'Create New Token',
        'section' => 'dpi_cc_general_options',
        'input_type' => 'button_link',
        'text' => 'Generate',
        'href' => 'https://api.constantcontact.com/mashery/account/yttqzt5hmkbzmaqyfjdkezfk',
        'target' => '_blank'
      ],
      'current_token' => [
        'id' => 'dpi_cc_access_token',
        'title' => 'Access Token',
        'section' => 'dpi_cc_general_options',
        'input_type' => 'text'
      ],
      'cc_lists' => [
        'id' => 'dpi_cc_list',
        'title' => 'Constant Contact List',
        'section' => 'dpi_cc_general_options',
        'input_type' => 'select'
      ]
    ],
    'non_registered' => [
      'get_token' => [
        'id' => 'dpi_cc_access_link',
        'title' => 'Connect Your Constant Contact Account',
        'section' => 'dpi_cc_general_options',
        'input_type' => 'button_link',
        'text' => 'Get Token',
        'href' => 'https://api.constantcontact.com/mashery/account/yttqzt5hmkbzmaqyfjdkezfk',
        'target' => '_blank'
      ],
      'save_token' => [
        'id' => 'dpi_cc_access_token',
        'title' => 'Access Token',
        'section' => 'dpi_cc_general_options',
        'input_type' => 'text'
      ]
    ]
  ];

  public function __construct() {
    add_action( 'admin_menu', [$this, 'add_page'] );
    add_action( 'admin_enqueue_scripts', [$this, 'register_assets'] );
    add_action( 'admin_init', [$this, 'page_init'] );
  }

  public function get_account_lists() {
    $opts = [
      'headers' => [
        'Authorization' => 'Bearer ' . get_option( 'dpi_cc_access_token' )
      ]
    ];

    $request = wp_remote_get( $this->base_endpoint . 'lists' . $this->key, $opts );

    if ( is_wp_error( $request ) ) {
      return false;
    } else {
      return json_decode( wp_remote_retrieve_body( $request ), true );
    }
  }

  public function add_page() {
    add_menu_page(
      'Constant Contact Settings',
      'Constant Contact',
      'manage_options',
      'dpi-cc-settings',
      [$this, 'create_page']
    );
  }

  public function register_assets() {
    wp_register_style( 'dpi-cc-plugin-page-css', plugins_url( '../css/plugin-page.css', __FILE__ ), '1.0.0', 'screen' );
    // wp_register_script( 'dpi-cc-plugin-page-js', plugins_url( '../js/plugin-page.js', __FILE__ ), null, '1.0.0', true );
  }

  public function page_init() {
    $this->generate_sections( $this->sections );

    if ( get_option( 'dpi_cc_access_token' ) ) {
      $this->generate_fields( $this->fields['registered'] );
    } else {
      $this->generate_fields( $this->fields['non_registered'] );
    }
  }

  public function generate_sections( $sections ) {
    foreach( $sections as $section ) {
      add_settings_section(
        $section['id'],
        $section['title'],
        [$this, 'sections_callback'],
        'dpi-cc-settings'
      );
    }
  }

  public function generate_fields( $fields ) {
    foreach( $fields as $field ) {
      add_settings_field(
        $field['id'],
        $field['title'],
        [$this, 'fields_callback'],
        'dpi-cc-settings',
        $field['section'],
        $args = [
          'id' => $field['id'],
          'type' => $field['input_type'],
          'options' => array_key_exists( 'options', $field ) ? $field['options'] : '',
          'min' => array_key_exists( 'min', $field ) ? $field['min'] : false,
          'max' => array_key_exists( 'max', $field ) ? $field['max'] : false,
          'default' => array_key_exists( 'default', $field ) ? $field['default'] : false,
          'text' => array_key_exists( 'text', $field ) ? $field['text'] : false,
          'target' => array_key_exists( 'target', $field ) ? $field['target'] : false,
          'href' => array_key_exists( 'href', $field ) ? $field['href'] : false
        ]
      );

      register_setting(
        $field['section'],
        $field['id'],
        [$this, 'dpi_cc_sanitize']
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
     case 'number':
        $min = is_numeric( $args['min'] ) ? 'min="' . $args['min'] . '"' : '';
        $max = is_numeric( $args['max'] ) ? 'max="' . $args['max'] . '"' : '';
        $value = is_numeric( $args['default'] ) && empty( get_option( $args['id'] ) ) ? $args['default'] : get_option( $args['id'] );
        echo '
          <input type="number" id="' . $args['id'] . '" name="' . $args['id'] . '" ' . $min . $max . ' value="' . $value . '" />
        ';
        break;
      case 'select':
        $lists = $this->get_account_lists();
        if ( $lists ) {
          $selected = get_option( $args['id'] );
          $select = '<select id="' . $args['id'] . '" name="' . $args['id'] . '">';
          foreach( $lists as $list ) {
            if ( $list['status'] === 'ACTIVE' || $list['status'] === 'HIDDEN' ) {
              $select .= '<option ' . ($selected == $list['id'] ? "selected" : "") . ' value="' . $list['id'] . '">' . $list['name'] . '</option>';
            } else {
              $select = '<p>Sorry, we were unable to retrieve any lists. Please make sure your lists are set to active and public.</p>';
            }
          }
          $select .= '</select>';
          print $select;
        } else {
          print '<p>Sorry, we\'re unable to retrieve your lists. Please make sure your access token is correct.</p>';
        }
        break;
      case 'button_link':
        print '<a id="' . $args['id'] . '" class="wp-core-ui button-primary" href="' . $args['href'] . '" target="' . $args['target'] . '">' . $args['text'] . '</a>';
        break;;
      default:
        printf(
          '<input type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
          !empty( get_option( $args['id'] ) ) ? get_option( $args['id'] ) : ''
        );
        break;
    }
  }

  public function dpi_cc_sanitize( $dirty ) {
    $clean = '';

    if ( is_string( $dirty ) ) {
      $clean = sanitize_text_field( $dirty );
    } else if ( is_int( $dirty ) ) {
      $clean = round( absint( $dirty ) );
    }

    return $clean;
  }

  public function create_page() {
    wp_enqueue_style( 'dpi-cc-plugin-page-css' );
    // wp_enqueue_script( 'dpi-cc-plugin-page-js' );
    ?>
    <div id="dpi-cc-settings-page" class="wrap">
      <?php settings_errors() ?>
      <h1>DPI Constant Contact Integration</h1>
      <form method="post" action="options.php" enctype="multipart/form-data">
        <?php
          do_settings_sections( 'dpi-cc-settings' );
          submit_button();
        ?>
      </form>
    </div>
    <?php
  }
}
