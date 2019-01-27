<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Blog_Init {

    public function __construct() {
        register_activation_hook(__FILE__, [$this, 'install']);
    }

    public function install() {
        update_option('dpi_blog_version', DPI_BLOG_VERSION);
        update_option('dpi_blog_max_articles', 10);
        update_option('dpi_blog_primary_color', '#efefef');
        update_option('dpi_blog_comonent', 'Cards');
    }

    public function checkForUpdates() {
        return false;
    }

    public function loadPlugin() {
        if (is_admin()) {
            new DPI_Blog_Plugin_Page();
        } else {
            new DPI_Blog_Shortcode();
        }
    }
}