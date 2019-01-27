<?php namespace DPI_Blog;

/*
Plugin Name: DPI Blog Posts
Plugin URI: http://www.diocesan.com
Description: Display blog posts from the Diocesan website.
Version: 1.0.0
Author: Josh Arens
Author URI: https://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define('DPI_BLOG_ROOT', __FILE__);

require __DIR__ . '/vendor/autoload.php';

use DPI_Blog\Classes\Init;

// Run setup on plugin activation
register_activation_hook(DPI_BLOG_ROOT, ['DPI_Blog\Classes\Init', 'install']);

// Uninstall on plugin deactivation
register_deactivation_hook(DPI_BLOG_ROOT, ['DPI_Blog\Classes\Init', 'uninstall']);

// kick it off
add_action('init', function() {
    $plugin = new Init();
    $plugin->checkForUpdates();
    $plugin->init();
});