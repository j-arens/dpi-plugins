<?php namespace DPISupport\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

use DPISupport\Plugin\App;

class Init {

    // classes
    private $app;

    // config
    private $entryPoint = 'dpi-support';
    private static $postTypeName = 'dpisupport_doc';
    private $apiNamespace = 'dpi-support';

    /**
    * Run on plugin activation
    */
    public static function onActivation() {

    }

    /**
    * Run on plugin deactivation
    */
    public static function onDeactivation() {

    }

    /**
    * Run update checker
    */
    public function checkForUpdates() {

    }

    /**
    * Startup
    */
    public function init() {

        if (is_admin()) {
            // $this->loadPluginPage();
        } else {
            $this->loadApp();
        }
    }

    /**
    * Config and start the pluginPage class
    */
    public function loadPluginPage() {

    }

    /**
    * Config and start the app class
    */
    public function loadApp() {
        $this->app = new App();
        $this->app->setEntryPoint($this->entryPoint);
        $this->app->init();
    }
}