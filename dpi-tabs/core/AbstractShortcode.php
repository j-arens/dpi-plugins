<?php namespace DpiTabs\core;

abstract class AbstractShortcode {

    /**
     * @var ComponentInterface
     */
    protected $component;

    /**
     * @var string
     */
    protected $shortcode;

    /**
     * @var integer
     */
    protected $instances = 0;

    /**
     * Shortcode constructor
     */
    // public function __construct(Component $component) {
    //     $this->shortcode = $component->shortcode;
    //     add_shortcode($this->shortcode, [$this, 'callback']);
    // }

    /**
     * Sanitize shortcode attributes
     * 
     * @param array $attrs
     * @return array
     */
    protected function sanitizeAttributes(array $attrs) {
        return array_map(function($attr) {
            switch (gettype($attr)) {
                case 'boolean':
                    return filter_var($attr, FILTER_VALIDATE_BOOLEAN); 
                case 'integer':
                    return filter_var($attr, FILTER_SANITIZE_NUMBER_FLOAT);
                default:
                    return sanitize_text_field($attr);
            }
        }, $attrs);
    }

    /**
     * Responds to shortcode calls
     * 
     * @param array $atts
     * @param string $content
     * @return function
     */
    abstract public function callback($attrs, $content);

}