<?php

/*
Plugin Name: DPI Bulletins
Plugin URI: http://www.diocesan.com
Description: Provides a quick method of auto generating links to church bulletins
Version: 2.4.0
Author: Diocesan Publications
Author URI: http://www.diocesan.com
License: GPLv2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// plugin constants
define('DPI_BULLETINS_ROOT', __FILE__);
define('DPI_BULLETINS_DIR', __DIR__);

// autoload plugin classes
require DPI_BULLETINS_DIR . '/psr4-autoloader.php';

// kick it off
add_action('init', function() {
    
    $plugin = Bulletins\Plugin\Controller::getInstance();
    $plugin->checkForUpdates();
    $plugin->init();
    
}, 0);