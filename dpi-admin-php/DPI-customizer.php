<?php

/*
Plugin Name: DPI Customizer
Plugin URI: http://www.diocesan.com
Description: Easily manage your site
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

    // modify user capabilities
    add_action( 'admin_init', array( $this, 'add_theme_caps') );

    // user info script
		add_action( 'admin_head', array( $this, 'pass_user_info' ) );

    // add settings page to menu
  	add_action( 'admin_menu' , array( $this, 'add_page' ) );

    // enqueue scripts
    add_action( 'in_admin_footer', array( $this, 'page_scripts' ) );

    // enqueue styles
    add_action( 'admin_enqueue_scripts', array( $this, 'page_styles' ) );
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
    add_menu_page( 'DPI Admin', 'DPI Admin', 'moderate_comments', 'dpi_admin', array( $this, 'create_root' ), 'dashicons-admin-home', 3 );
  }

  /**
  * Output react root to our page
  */
  public function create_root() {
    echo '<div id="root">...</div>';
  }

  /**
  * Load react app
  */
  public function page_scripts() {

    // media picker
    wp_enqueue_media();

    // react
    wp_enqueue_script( 'dpi_admin_scripts', $this->plugin_dir . 'assets/js/main.7fb9f818.js', array( 'farbtastic' ), '1.0.0', true );
  }

  /**
  * Load styles
  */
  public function page_styles() {

    // register style then enqueue it
    wp_register_style( 'dpi_admin_styles', $this->plugin_dir . 'assets/css/main.19c8bd70.css' , '1.0.0', 'all' );
    wp_enqueue_style( 'dpi_admin_styles' );
  }
}

// instantiate only if coming from wp dashboard
if ( is_admin() )
    $dpi_cal = new DPI_Customizer();
