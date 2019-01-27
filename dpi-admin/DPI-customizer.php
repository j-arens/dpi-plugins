<?php

/*
Plugin Name: DPI Customizer
Plugin URI: http://www.diocesan.com
Description: Easily manage your site.
Author: Diocesan Publications
Version: 1.0.0
Author URI: http://github.com/j-arens
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Customizer {
  private $plugin_dir;

  /**
  * Constructor
  */
  public function __construct() {
    $this->plugin_dir = plugin_dir_url( __FILE__ );

    // setup initial state
    $this->set_state();

    // ajax post handler
    add_action( 'wp_ajax_save_state', [$this, 'save_state'] );

    // ajax get handler
    add_action( 'wp_ajax_get_state', [$this, 'retrieve_state'] );

    // modify user capabilities
    add_action( 'admin_init', [$this, 'add_theme_caps'] );

    // user info script
		add_action( 'admin_head', [$this, 'pass_user_info'] );

    // add settings page to menu
  	add_action( 'admin_menu' , [$this, 'add_page'] );

    // enqueue scripts
    add_action( 'in_admin_footer', [$this, 'page_scripts'] );

    // enqueue styles
    add_action( 'admin_enqueue_scripts', [$this, 'page_styles'] );
  }

  /**
  * Save initial state to options
  */
  public function set_state() {
    if ( empty( get_option( 'dpi_admin_app_state' ) ) ) {

      $pages = array(
      array(
        'id' => "1",
        'name' => 'Builder',
      )
    );

      $state_obj = array(
        'pages' => $pages,
        'sections' => array_values( [] ),
        'components' => array_values( [] ),
        'elements' => array_values( [] ),
        'fields' => array_values( [] ),
      );

      $data = $state_obj;

      update_option( 'dpi_admin_app_state',  $data );
    }
  }

  /**
	* Fix capabilities
	*/
	public function add_theme_caps() {
	    $role = get_role( 'editor' );
	    $role->add_cap( 'manage_options' );
	}

  /**
  * Pass current user info to js
  */
	public function pass_user_info() {
		$user_info = json_encode( wp_get_current_user() );
		echo '<script> var _current_user_info_ =' . $user_info . ';</script>';
	}

  /**
  * Add dpi admin page to admin menu
  */
  public function add_page() {
    add_menu_page( 'DPI Admin', 'DPI Admin', 'manage_options', 'dpi_admin', array( $this, 'create_root' ), 'dashicons-admin-home', 3 );
  }

  /**
  * Output react root to our page
  */
  public function create_root() {
    echo '<div id="dpi-admin-root">...</div>';
  }

  /**
  * Load js
  */
  public function page_scripts() {

    // load wp media picker
    wp_enqueue_media();

    // react
    wp_enqueue_script( 'dpi_admin_scripts', $this->plugin_dir . 'assets/js/main.35297e6e.js', '0.0.41', true );
  }

  /**
  * Load styles
  */
  public function page_styles() {

    // root styles
    wp_register_style('dpi_admin_root_styles', $this->plugin_dir . 'assets/css/root.css', '0.0.1', 'all' );
    wp_enqueue_style( 'dpi_admin_root_styles' );

    // app styles
    wp_register_style( 'dpi_admin_styles', $this->plugin_dir . 'assets/css/main.66252d3a.css' , '0.0.6', 'all' );
    wp_enqueue_style( 'dpi_admin_styles' );
  }

  /**
  * Hook for ajax post from react app
  */
  public function save_state() {
    $state = $_POST['state'];
    update_option( 'dpi_admin_app_state', $state );
    $this->save_fields( $state );
    wp_die();
  }

  /**
  * Save individual fields
  */
  public function save_fields( $state ) {
    foreach( $state['fields'] as $k => $v ) {
      $opt_name = $v['name'] . '_' . $v['type'] . '_' . $v['id'];
      update_option( $opt_name, $v['val'] );
    }
  }

  /**
  * Hook for ajax get from react app
  */
  public function retrieve_state() {
    $state = get_option( 'dpi_admin_app_state', false );
    echo json_encode( $state );
    wp_die();
  }
}

// instantiate only if coming from wp dashboard
if (is_admin()) {
  $dpi_admin = new DPI_Customizer();
}
