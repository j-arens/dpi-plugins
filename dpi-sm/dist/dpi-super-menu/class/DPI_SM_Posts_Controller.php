<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_SM_Posts_Controller extends WP_REST_Posts_Controller {

  protected 'dpism/v1';
  protected $post_type;
  protected 'items';

  public function register_routes() {
    register_rest_route( $this->namespace, '/' . $this->rest_base, [
        [
          'methods' => WP_REST_Server::READABLE,
          'callback' => [$this, 'get_items'],
          'permissions_callback' => [$this, 'get_items_permissions_check'],
          'args' => $this->get_collection_params(),
          'show_in_index' => false
        ],
      ] );
  }
}
