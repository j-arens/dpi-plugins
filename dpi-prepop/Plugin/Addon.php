<?php namespace PrePopulate\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Addon {

    /**
    * Load the front-end client js
    */
    public function loadFrontEndScripts() {
        wp_enqueue_script('wpi-api');

        wp_enqueue_script(
            'fc-dpiprepop-client-js',
            plugins_url('/js/addon-client.min.js', DPI_PREPOPULATE_ROOT),
            ['jquery', 'wp-api'],
            filemtime(DPI_PREPOPULATE_DIR . '/js/addon-client.min.js'),
            true
        );
    }

    /**
    * Load the admin formcraft builder js
    */
    public function loadBackendScripts() {
        wp_enqueue_script(
            'fc-dpiprepop-addon-js',
            plugins_url('/js/addon-backend.min.js', DPI_PREPOPULATE_ROOT),
            null,
            filemtime(DPI_PREPOPULATE_DIR . '/js/addon-backend.min.js')
        );
    }

    /**
    * Get the addon tab markup
    */
    public function addonTabMarkup() {
        ob_start();
        include DPI_PREPOPULATE_DIR . '/includes/addon-tab-template.php';
        echo ob_get_clean();
    }
    
    /**
    * Register plugin as a formcraft addon
    */
    public function registerAddon() {
        register_formcraft_addon([$this, 'addonTabMarkup'], 0, 'DPI Pre-populate', 'DpiPrePopController', 0, 0, 0);
        add_action('formcraft_addon_scripts', [$this, 'loadBackendScripts']);
        add_action('formcraft_form_scripts', [$this, 'loadFrontendScripts']);
    }
}