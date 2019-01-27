<?php namespace PrePopulate\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class PrePopulate {

    private $API;
    private $Addon;

    /**
    * Hook in plugin classes
    */
    public function init() {
        $this->Addon = new Addon();
        add_action('formcraft_addon_init', [$this->Addon, 'registerAddon']);

        if (!is_admin()) {
            $this->API = new API();
            add_action('rest_api_init', [$this->API, 'registerRoutes']);
        }
    }
}