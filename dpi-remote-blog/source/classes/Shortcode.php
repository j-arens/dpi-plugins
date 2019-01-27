<?php namespace DPI_Blog\Classes;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Shortcode {

    private $shortcodeKey;
    private $factory;
    private static $instance;

    /**
    * Set the shortcode key
    */
    public function setShortcodeKey($str) {
        if (gettype($str) === 'string') {
            $this->shortcodeKey = $str;
        } else {
            throw new \Exception('DPI_BLOG_SHORTCODE: setShortcodeName expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Set the factory
    */
    public function setFactory($obj) {
        if (gettype($obj) === 'object') {
            $this->factory = $obj;
        } else {
            throw new \Exception('DPI_BLOG_SHORTCODE: setFactory expects an object. You passed a(n)' . gettype($obj) . '.');
            return false;
        }
    }

    /**
    * Startup
    */
    public function init() {
        if (count(array_filter(get_object_vars($this))) === 2) {
            add_shortcode($this->shortcodeKey, [$this, 'shortcodeHandler']);
        } else {
            throw new \Exception('DPI_BLOG_SHORTCODE: $shortcodeKey and $factory must be set before calling init!');
            return false;
        }
    }

    /**
    * Sanitize shortcode atts
    */
    private function sanitizeArgs($args) {
        return array_map(function($dirty) {
            switch (gettype($dirty)) {
                case 'boolean':
                    return $dirty === true ? true : false;
                case 'integer':
                    return round(absInt($dirty));
                default:
                    return sanitize_text_field($dirty);
            }
        }, $args);
    }

    /**
    * Shortcode callback
    */
    public function shortcodeHandler($atts) {
        $args = shortcode_atts([
            'component' => get_option('dpi_blog_component', 'article cards'),
            'max_posts' => 3
        ], $atts);

        if (self::$instance) {
            return $this->factory->createError(
                'DPI_BLOG_PLUGIN: Too many component instances. The shortcode "['.$this->shortcodeKey.']" may only be used once per page.'  
            );
        }

        self::$instance = true;
        return $this->factory->createComponent($this->sanitizeArgs($args)); 
    }
}