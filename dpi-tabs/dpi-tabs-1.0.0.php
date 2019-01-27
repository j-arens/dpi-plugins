<?php

/*
Plugin Name: DPI Tabs Component
Plugin URI: 
Description: A developer friendly tabs component.
Version: 1.0.0
Author: Josh Arens
Author URI: jarens.me
License: GPL-2.0
*/

define('DPITABS_ROOT', __FILE__);
define('DPITABS_DIR', __DIR__);

add_action('init', function() {

    if (version_compare(PHP_VERSION, '5.6', '<')) {
        return add_action('all_admin_notices', function() {
            ob_start();
            include DPITABS_DIR . '/includes/incompatible.php';
            return ob_get_clean();
        });
    }

    if (!is_admin()) {
        require 'bootstrap.php';
    }

}, 0);
