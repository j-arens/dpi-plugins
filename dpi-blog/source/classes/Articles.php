<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Blog_Articles {

    private $settings = [
        'max_articles' => 10,
        'primary_color' => 'red',
        'component' => 'cards'
    ];

    public function __construct() {
        $this->getAdminSettings();
    }

    private function getAdminSettings() {
        $this->mergeSettings(
            array_map(function($key) {
                return get_option('dpi_blog_articles' . $key, false);
            }, array_keys($this->settings))
        );
    }

    public function mergeSettings($args) {
        if (is_array($args) && in_array(array_keys($args), $this->settings)) {
            array_merge($this->settings, $args);
        } else {
            throw new Exception('DPI Blog Articles: Invalid shortcode or plugin page settings!');
            return false;
        }
    }

    private function enqueueAssets() {
        wp_enqueue_style('dpi-blog-css', plugins_url('../css/main.min.css', __FILE__), null, '1.0.0', 'all');
        wp_enqueue_style('dpi-blog-component-css', plugins_url('../css/' . $this->settings['component'] . '.min.css', __FILE__), null, '1.0.0', 'all');
        wp_enqueue_script('dpi-blog-js', plugins_url('../js/app.min.js', __FILE__), null, '1.0.0', true);
    }

    public function renderRoot() {
        $this->enqueueAssets();
        return '
            <div id="dpi-blogArticles--root">
                <svg class="dpi-blogArticles--spinner">
                    <circle cx="0" cy="0" cr="100"/>
                </svg>
            </div>
        ';
    }
}