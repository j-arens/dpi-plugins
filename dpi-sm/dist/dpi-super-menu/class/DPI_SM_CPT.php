<?php

// namespace DPI_SM\DPI_SM_CPT;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_SM_CPT {

  public function __construct() {
    add_action( 'init', [$this, 'create_cpt'] );
    // $this->register_rest_meta();
  }

  public function create_cpt() {
    $labels = [
      'name' => _x( 'Menu Item', 'post type general name' ),
      'singular_name' => _x( 'Menu Item', 'post type singular name' ),
      'add_new' => _x( 'Add New Menu Item', 'book' ),
      'add_new_item' => __( 'Add New Menu Item' ),
      'edit_item' => __( 'Edit Menu Item' ),
      'new_item' => __( 'New Menu Item' ),
      'all_items' => __( 'All Menu Items' ),
      'view_item' => __( 'View Menu Item' ),
      'search_items' => __( 'Search Menu Items' ),
      'not_found' => __( 'No Menu Items Found' ),
      'not_found_in_trash' => __( 'No Menu Items in Trash' ),
      'menu_name' => 'DPI Super Menu'
    ];

    $args = [
      'labels' => $labels,
      'description' => 'Site navigation menu items.',
      'public' => false,
      'show_ui' => true,
      'show_in_nav_menus' => false,
      'exclude_from_search' => true,
      'has_archive' => false,
      'rewrite' => false,
      'menu-position' => 5,
      'supports' => ['title', 'editor'],
      'show_in_rest' => true, // hooray, rest api!
      'rest_base' => 'dpi-sm' // endpoint will be /wp-json/wp/v2/dpi-sm
    ];

    register_post_type( 'dpi_super_menu', $args );
  }

  // public function register_rest_meta() {
  //   $callbacks = [
  //     'get_callback' => function( $data ) {
  //       return get_post_meta( $data['id'], 'dpi_super_menu_state', true );
  //     },
  //     'update_callback' => function( $data, $post ) {
  //       update_post_meta( $post->ID, 'dpi_super_menu_state', json_encode( stripslashes( $data ) ) );
  //     }
  //   ];
  //
  //   register_rest_field( 'post', 'dpi_sm_metabox', $callbacks );
  // }
}
