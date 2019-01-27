<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// singleton!
class Controller {

    // singleton instance
    private static $instance = false;

    // global plugin objects
    public $Transport;

    // options config, make these global so other objects can refer to them  
    protected $idOptionName = 'dpi_bulletins_id';
    protected $quantityOptionName = 'dpi_bulletins_quantity';

    /**
    * Get or create controller instance
    */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Controller();
        }

        return self::$instance;
    }

    /**
    * Check for updates, alert wp if there are any
    */
    public function checkForUpdates() {
        return false;
    }

    /**
    * Load up neccessary plugin objects based on the current view
    */
    public function init() {
        // widget needs to be loaded on both admin and frontend
        add_action('widgets_init', function() {
            return register_widget(__NAMESPACE__ . '\\Widget');
        });

        if (is_admin()) {
            new PluginPage([
                'pageTitle' => 'Bulletins Options',
                'menuTitle' => 'DPI Bulletins',
                'capability' => 'manage_options'
            ]);
        } else {
            $this->Transport = new Transport();
            new Shortcodes();
        }
    }

    /**
    * Attempt to retrieve user input bulletin id from options table, otherwise return false
    */
    public function getBulletinID() {
        $id = get_option($this->idOptionName, false);

        if (!$id) {
            return false;
        }

        return $id;
    }

    /**
    * Attempty to retrieve user input quantity from options table, otherwise return false
    */
    public function getBulletinQuantity() {
        $quantity = get_option($this->quantityOptionName, false);

        if (!$quantity) {
            return false;
        }

        return $quantity;
    }
}