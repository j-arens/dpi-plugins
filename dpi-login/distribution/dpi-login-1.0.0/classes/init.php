<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once __DIR__ .  '/plugin-page.php';
require_once __DIR__ . '/custom-styles.php';

class DPI_Login_Init {

    public function __construct() {
        register_activation_hook(__FILE__, [$this, 'install']);
    }

    public function install() {
        update_option('DPI_LOGIN_VERSION', DPI_LOGIN_VERSION);
        update_option('dpi_login_logo_link', '/');
    }

    public function checkForUpdates() {
        return false;
    }

    public function loadPlugin() {
        if (is_admin()) {
            new DPI_Login_Plugin_Page();
        } else {
            new DPI_Login_Styles();
        }
    }
}
