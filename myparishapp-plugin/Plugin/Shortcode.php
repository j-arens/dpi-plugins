<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Shortcode {

    use PreFlight;

    private $shortcodeName;
    private $Factory;
    private $prefix;
    private static $invoked = false;

    /**
    * Set the shortcodeName prop
    * @param{string} $str
    */
    public function setShortcodeName($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->shortcodeName = $str;
    }

    /**
    * Set the factory prop
    * @param{object} $obj
    */
    public function setFactory($obj) {
        if (!$this->compareType('object', $obj)) {
            $this->invalidType('object', $obj);
            return false;
        }

        $this->Factory = $obj;
    }

    /**
    * Set the prefix prop
    * @param{string} $str
    */
    public function setIdPrefix($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->prefix = $str;
    }

    /**
    * Startup
    */
    public function init() {
        if ($this->allPropsSet()) {
            add_shortcode($this->shortcodeName, [$this, 'shortcodeHandler']);
        }
    }

    /**
    * Sanitize shortcode atts
    * @param{array} $args
    * @return array
    */
    private function sanitizeShortcodeArgs(Array $args) {
        return array_map(function($dirty) {
            switch (gettype($dirty)) {
                case 'boolean':
                    return filter_var($dirty, FILTER_VALIDATE_BOOLEAN);
                case 'integer':
                    return round(filter_var($dirty, FILTER_SANITIZE_NUMBER_FLOAT));
                default:
                    return sanitize_text_field($dirty);
            }
        }, $args);
    }

    /**
    * Shortcode callback
    * @param{array} $atts
    * @return component
    */
    public function shortcodeHandler($atts) {
        $args = $this->sanitizeShortcodeArgs(shortcode_atts([
            'component' => get_option($this->prefix . 'component') ?: 'slider',
            'max_messages' => get_option($this->prefix . 'max_messages') ?: -1,
            'deep_link' => get_option($this->prefix . 'deep_link') ?: false,
            'primary_color' => get_option($this->prefix . 'primary_color') ?: false,
            'secondary_color' => get_option($this->prefix . 'secondary_color') ?: false,
            'accent_color' => get_option($this->prefix . 'accent_color') ?: false,
            'text_color' => get_option($this->prefix . 'text_color') ?: false,
            'link_color' => get_option($this->prefix . 'link_color') ?: false
        ], $atts));

        if (self::$invoked) {
            return $this->Factory->createError(
                'MYPARISHAPP_PLUGIN: Too many component instances. The shortcode "['.$this->shortcodeName.']" may only be used once per page.'
            );
        }

        self::$invoked = true;
        return $this->Factory->createComponent($args);
    }
}