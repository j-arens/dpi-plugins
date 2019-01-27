<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Expose a global function to get mpa messages without using the shortcode
* @param{int} $quantity
* @return function
*/
function getMpaMessages($quantity = -1) {
    return MyParishApp::externalQuery($quantity);
}

class MyParishApp {

    // classes
    private $Cron;
    private $Messages;
    private $PluginPage;
    private $Shortcode;
    private $Factory;

    // config
    private $authKey;
    private $cronEventName = 'myparishapp_sync';
    private $cronIntervalName = 'hourly';
    private $cronIntervalSeconds = 900;
    private $shortcodeName = 'dpi_mpa_messages';
    private $apiEndpoint = 'http://kit.myparishapp.com/feed-messages/?authKey=';
    private $components = ['error', 'carousel', 'slider'];
    private $pluginPageTitle = 'MyParish App';
    private $pluginPageMenuTitle = 'MyParish App';
    private $pluginPageUserCapability = 'manage_options';
    private $pluginPageIconPath = '/assets/icons/mpa-icon.svg';
    private static $postTypeName = 'myparish_messages';
    private static $prefix = 'myparish_app_';

    /**
    * Setup defaults on plugin activation
    */
    public static function install() {
        update_option(self::$prefix . 'authkey', false);
    }

    /**
    * Clean up on plugin deactivation
    */
    public static function uninstall() {
        $storedMessages = get_posts([
            'post_type' => self::$postTypeName,
            'post_status' => ['publish', 'future', 'pending', 'trash'],
            'numberposts' => -1
        ]);

        foreach($storedMessages as $message) {
            wp_delete_post($message->ID, true);
        }

        delete_option(self::$prefix . 'authkey');
    }

    /**
    * Wrapper around get_posts for external queries
    * @param{int} $quantity
    * @return array
    */
    public static function externalQuery($quantity) {
        return get_posts([
            'post_type' => self::$postTypeName,
            'post_status' => ['publish', 'future'],
            'numberposts' => $quantity
        ]);
    }

    /**
    * Startup
    */
    public function init() {
        $this->authKey = get_option(self::$prefix . 'authkey', false);

        if ($this->authKey) {
            $this->loadCron();
            $this->loadMessages();
            $this->loadFactory();

            if (!is_admin()) {
                $this->loadShortcode();
            }
        }

        if (is_admin()) {
            $this->loadPluginPage();
        }
    }

    /**
    * Init the cron class
    */
    private function loadCron() {
        $this->Cron = new Cron();
        $this->Cron->setEventName($this->cronEventName);
        $this->Cron->setInterval($this->cronIntervalName, $this->cronIntervalSeconds);
        $this->Cron->init();
    }

    /**
    * Init the messages class
    */
    private function loadMessages() {
        $this->Messages = new Messages();
        $this->Messages->setAuthKey($this->authKey);
        $this->Messages->setPostTypeName(self::$postTypeName);
        $this->Messages->setEventName($this->cronEventName);
        $this->Messages->setApiEndpoint($this->apiEndpoint);
        $this->Messages->Init();
    }

    /**
    * Init the factory class
    */
    private function loadFactory() {
        $this->Factory = new Factory();
        $this->Factory->setPostTypeName(self::$postTypeName);
        $this->Factory->setComponents($this->components);
    }

    /**
    * Init the plugin page class
    */
    private function loadPluginPage() {
        $this->PluginPage = new PluginPage();
        $this->PluginPage->setPageTitle($this->pluginPageTitle);
        $this->PluginPage->setMenuTitle($this->pluginPageMenuTitle);
        $this->PluginPage->setMenuIconPath($this->pluginPageIconPath);
        $this->PluginPage->setUserCapability($this->pluginPageUserCapability);
        $this->PluginPage->setPrefix(self::$prefix);
        $this->PluginPage->init();
    }

    /**
    * Init the shortcode class
    */
    private function loadShortcode() {
        $this->Shortcode = new Shortcode();
        $this->Shortcode->setShortcodeName($this->shortcodeName);
        $this->Shortcode->setFactory($this->Factory);
        $this->Shortcode->setIdPrefix(self::$prefix);
        $this->Shortcode->init();
    }
}