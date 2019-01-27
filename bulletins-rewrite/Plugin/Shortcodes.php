<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Shortcodes {

    private $bulletinsShortcode = 'bulletins';
    private $coverShortcode = 'bulletin_cover';

    /**
    * Init, run wp hooks
    */
    public function __construct() {
        add_shortcode($this->bulletinsShortcode, [$this, 'shortcodeHandler']);
        add_shortcode($this->coverShortcode, [$this, 'shortcodeHandler']);
    }

    /**
    * Sanitize shortcode parameters
    */
    private function sanitizeParams(array $params) {
        return array_map(function($dirty) {
            switch(gettype($dirty)) {
                case 'boolean':
                    return filter_var($dirty, FILTER_VALIDATE_BOOLEAN);
                case 'integer':
                    return round(filter_var($dirty, FILTER_SANITIZE_NUMBER_FLOAT));
                default:
                    return sanitize_text_field($dirty);
            }
        }, $params);
    }

    /**
    * Shortcode callback handler
    */
    public function shortcodeHandler($params, $content, $shortcode) {
        $Controller = Controller::getInstance();

        $args = ($this->sanitizeParams(shortcode_atts([
            'id' => $Controller->getBulletinID(),
            'quantity' => $Controller->getBulletinQuantity(),
            'title' => false,
            'cover_count' => 0
        ], $params)));

        if (!$args['id']) {
            return false;
        }

        switch($shortcode) {
            case $this->bulletinsShortcode:
                $bulletins = $Controller->Transport->getBulletins($args['id'], $args['quantity']);
                ob_start();
                include DPI_BULLETINS_DIR . '/includes/shortcode-bulletins-template.php';
                return ob_get_clean();
            case $this->coverShortcode:
                $bulletins = $Controller->Transport->getBulletins($args['id'], 1);
                $bulletin = is_array($bulletins) ? array_shift($bulletins) : '';
                ob_start();
                include DPI_BULLETINS_DIR . '/includes/shortcode-cover-template.php';
                return ob_get_clean();
        }
    }
}