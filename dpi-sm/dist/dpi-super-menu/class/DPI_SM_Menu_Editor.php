<?php

// namespace DPI_SM\DPI_SM_Menu_Editor;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_SM_Menu_Editor {

  public function __construct() {
    add_action( 'add_meta_boxes', [$this, 'init'] );
    add_action( 'admin_enqueue_scripts', [$this, 'load_assets'] );
    // add_action( 'save_post_dpi_super_menu', [$this, 'save_state'] );
    add_action( 'wp_ajax_dpism_save_state', [$this, 'save_state'] );
  }

  public function init() {
    add_meta_box( 'dpi_sm_metabox', 'Menu Item Editor', [$this, 'render'], 'dpi_super_menu', 'normal', 'high', null );
  }

  public function load_assets() {
    wp_register_script( 'dpi-sm-be-js', plugins_url( 'assets/js/backend/app-be.min.js', realpath( __DIR__ ) ), ['jquery', 'jquery-ui-sortable'], '1.0.0', true );
    wp_register_style( 'dpi-sm-be-css', plugins_url( 'assets/css/backend/main.css', realpath( __DIR__ ) ), null, '1.0.0' );
    wp_enqueue_style( 'dpi-sm-be-css' );
  }

  public function verify_nonce() {
    if ( isset( $_POST['dpism_nonce'] ) && wp_verify_nonce( $_POST['dpism_nonce'], 'dpism_data' ) ) {
      return true;
    } else {
      return false;
    }
  }

  public function verify_post( $id ) {
    if ( !wp_is_post_revision( $id ) && current_user_can( 'edit_post', $id ) ) {
      return true;
    } else {
      return false;
    }
  }

  public function save_state() {
    $state = json_decode( $_POST['dpism_save_state'] );

    if ( get_post_status( $state['post_id'] ) === 'publish' ) {
      update_post_meta( $state['post_id'], 'dpi_super_menu_state', $state );
    } else {
      $postarr = [
        'post_type' => 'dpi_super_menu',
        'ID' => $state['post_id'],
        'user_id' => get_current_user_id(),
        'post_title' => $state['components']['itemType']['menuItemName'],
        'post_status' => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
      ];

      wp_insert_post();
      update_post_meta( $state['post_id'], 'dpi_super_menu_state', $state );
    }

    wp_die();
  }

  // public function save_state( $post_id ) {
  //   if ( $this->verify_nonce() && $this->verify_post( $post_id ) ) {
  //     update_post_meta( $post_id, 'dpi_super_menu_state', stripslashes( $_POST[ 'dpi_super_menu_state' ] ) );
  //   }
  // }

  public function render() {
    $translation = [
      'post_id' => get_the_ID(),
      'menu_items' => get_posts( ['post_type' => 'dpi_super_menu', 'post_status' => 'publish'] ),
      'wrapped_state' => get_post_field( 'post_content', get_the_ID() ),
      'rest_url' => esc_url_raw( rest_url() ),
      'nonce' => wp_create_nonce( 'wp_rest' )
    ];
    ?>
    <div id="dpi-sm-editor-root" class="uk-padding">
      <div id="ItemType-root">
        <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" ratio="1">
          <circle fill="none" stroke="#000" cx="15" cy="15" r="14"></circle>
        </svg>
      </div>
    </div>
    <?php
    wp_localize_script( 'dpi-sm-be-js', 'dpism_pod', $translation );
    wp_enqueue_script( 'dpi-sm-be-js' );
  }
}
