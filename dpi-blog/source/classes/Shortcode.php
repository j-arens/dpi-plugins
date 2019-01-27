<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Blog_Shortcode {

    public function __construct() {
        add_shortcode('dpi_blog', [$this, 'shortcodeHandler']);
    }

    private function sanitizeAtts($atts) {
        return array_map(function($att) {
            switch(gettype($att)) {
                case 'string':
                    return sanitize_text_field($att);
                case 'boolean':
                    return $att ? true : false;
                case 'integer':
                case 'double':
                case 'float':
                    return round(absint($att));
                default:
                    throw new Exception('DPI Blog Shortcode: Tried to sanitize a(n) ' . gettype($att) . '! Shortcode arguments can only be a string, boolean, or number.');
                    return false;
            }
        }, $atts);
    }

    public function shortcodeHandler($atts) {
        $shortcodeArgs = $this->sanitizeAtts($atts);
        $articles = new DPI_Blog_Articles();
        $articles->mergeSettings($shortcodeArgs);
        return $articles->renderRoot();
    }
}