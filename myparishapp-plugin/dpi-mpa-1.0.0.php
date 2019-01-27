<?php

/*
Plugin Name: DPI myParish Integration
Plugin URI: http://www.diocesan.com
Description: Allows you to integrate your myParish app with your website
Version: 1.0.0
Author: Diocesan Publications
Author URI: http://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define('MYPARISHAPP_DIR', __DIR__);
define('MYPARISHAPP_ROOT', __FILE__);

require MYPARISHAPP_DIR . '/vendor/autoload.php';

// Run setup on plugin activation
register_activation_hook(MYPARISHAPP_ROOT, ['MyParishApp\Plugin\MyParishApp', 'install']);

// Uninstall on plugin deactivation
register_deactivation_hook(MYPARISHAPP_ROOT, ['MyParishApp\Plugin\MyParishApp', 'uninstall']);

// kick it off
add_action('init', function() {

    $plugin = new MyParishApp\Plugin\MyParishApp();
    $plugin->init();

}, 0);