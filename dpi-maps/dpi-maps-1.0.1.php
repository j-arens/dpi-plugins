<?php

/*
Plugin Name: DPI Maps
Plugin URI: http://www.diocesan.com
Description: Easily embed customized google maps.
Version: 1.0.1
Author: Josh Arens
Author URI: https://github.com/j-arens
License: GPL-2.0
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define('DPI_MAPS_ROOT', __FILE__);
define('DPI_MAPS_DIR', __DIR__);

// autoload plugin classes
require DPI_MAPS_DIR . '/autoloader.php';

register_activation_hook(DPI_MAPS_ROOT, ['DPIMaps\Plugin\DPIMaps', 'install']);

add_action('init', function() {
    
    $plugin = new DPIMaps\Plugin\DPIMaps();
    $plugin->init();
    
});
