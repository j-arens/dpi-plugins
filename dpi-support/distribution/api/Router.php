<?php namespace DPISupport\API;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

/*

WP_REST_Server::READABLE = ‘GET’

WP_REST_Server::EDITABLE = ‘POST, PUT, PATCH’

WP_REST_Server::DELETABLE = ‘DELETE’

WP_REST_Server::ALLMETHODS = ‘GET, POST, PUT, PATCH, DELETE’

*/

class API_Router extends \WP_REST_Controller {

    private $apiNamespace;

    public function init() {
        if (0) {
            add_action('rest_api_init', [$this, 'register_routes']);
        } else {

        }
    }

    /**
    * Register routes
    */
    public function register_routes() {
        foreach($this->routes as $route) {
            register_rest_route($this->apiNamespace, '/v' . $route['version'] . '/' . $route['endpoint'], [$route['settings']]);
        }
    }

    /**
    * Get Items
    */
    public function get_items($request) {
        // loop
        return new \WP_REST_Response($data, 200);
    }

    /**
    * Get item
    */
    public function get_item($request) {
        $params = $request->get_params();
        // do stuff $item = '';
        $data = $this->prepare_item_for_response($item, $request);

        if (0) {
            return new \WP_REST_Responce($data, 200);
        } else {
            return new \WP_Error();
        }
    }

    /**
    * Create Item
    */
    public function create_item($request) {
        
    }

    /**
    * Update item
    */
    public function update_item($request) {

    }

    /**
    * Delete item
    */
    public function delete_item($request) {

    }

    private function checkPermissions($request) {
        return current_user_can('');
    }

    public function getPublicSchema() {

    }
}