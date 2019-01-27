<?php namespace DpiTabs\plugin;

use DpiTabs\core\Container;

Class Plugin {

    /**
     * @var Plugin
     */
    protected static $instance;

    /**
     * @var Container
     */
    protected static $container;

    /**
     * Plugin constructor
     * 
     * @return Plugin
     */
    public function __construct() {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        self::$container = new Container;
        return self::$instance;
    }

    /**
     * Load in plugin services
     * 
     * @return void
     */
    public function loadServices() {
        $container = self::$container;
        $container->bind('AssetLoader', 'DpiTabs\\core\\AssetLoader');
        $container->bind('TabsComponent', 'DpiTabs\\plugin\\TabsComponent');
        $container->bind('TabsShortcode', 'DpiTabs\\plugin\\TabsShortcode');
        $container->bind('TabShortcode', 'DpiTabs\\plugin\\TabShortcode');
    }

    /**
     * Build out plugin bindings
     * 
     * @return void
     */
    public function build() {
        $container = self::$container;
        $container->resolve('TabsShortcode');
        $container->resolve('TabShortcode');
    }

}