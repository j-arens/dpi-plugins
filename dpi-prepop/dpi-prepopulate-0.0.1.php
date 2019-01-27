<?php

/*
Plugin Name: FormCraft DPI Pre-populate Addon
Plugin URI: https://github.com/j-arens/dpi-prepop
Description: Adds special fields that will be prepopulated in the client with DPI specefic data.
Version: 0.0.1
Author: Josh Arens
Author URI: jarens.me
License: MIT
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// plugin constants
define('DPI_PREPOPULATE_ROOT', __FILE__);
define('DPI_PREPOPULATE_DIR', __DIR__);

// autoload plugin classes
require DPI_PREPOPULATE_DIR . '/autoloader.php';

// kick it off
add_action('init', function() {
    $plugin = new PrePopulate\Plugin\PrePopulate();
    $plugin->init();
}, 0);