<?php

/*
Plugin Name: DPI Documentation Module
Plugin URI: http://www.diocesan.com
Description: Provides custom documentation and support to DPI Clients.
Version: 0.0.1
Author: Josh Arens
Author URI: https://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define('DPISUPPORT_DIR', __DIR__);
define('DPISUPPORT_ROOT', __FILE__);
define('DPISUPPORT_VERSION', '0.0.1');

require __DIR__ . '/vendor/autoload.php';

use DPISupport\Plugin\Init;

// Setup activation hook
register_activation_hook(DPISUPPORT_ROOT, ['DPIDocs\Plugin\Init', 'onActivation']);

// Setup decativation hook 
register_deactivation_hook(DPISUPPORT_ROOT, ['DPIDocs\Plugin\Init', 'onDeactivation']);

// Run it
add_action('init', function() {
    $plugin = new Init();
    $plugin->checkForUpdates();
    $plugin->init();
});