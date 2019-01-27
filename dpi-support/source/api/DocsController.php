<?php namespace DPISupport\API;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Docs extends \WP_REST_Controller {

    private $apiNamespace;
    private $routes;

    public function register_routes() {
        foreach($this->routes as $route) {
            register_rest_route($this->apiNamespace . '/v' . $route['version'] . '/' . $route['endpoint'], [$route['settings']]);
        }
    }

}