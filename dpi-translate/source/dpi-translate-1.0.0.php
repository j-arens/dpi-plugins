<?php

/*
Plugin Name: DPI Translate
Plugin URI: http://www.diocesan.com
Description: Developer friendly wrapper around Google's webpage translation services.
Version: 1.0.0
Author: Josh Arens
Author URI: http://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once dirname(__FILE__) . '/classes/DPI_Translate.php';

add_action('init', function() {
    $plugin = new DPI_Translate();
    $plugin->init();
});