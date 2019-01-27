<?php namespace DPIMaps\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Shortcode {
    
    private $shortcodeName;
    private static $instances = 0;
    
    public function __construct($shortcode) {
        
        if (shortcode_exists($shortcode)) {
            return new \WP_Error('DPI_MAPS_ERR', 'The shortcode <code>' . $shortcode . '</code> already exists!');
        }
        
        $this->shortcodeName = $shortcode;
    }
    
    public function register() {
        add_shortcode($this->shortcodeName, [$this, 'handler']);
    }
    
    public function handler() {
        self::$instances++;
        
        if (self::$instances > 1) {
            new \WP_Error('DPI_MAPS_ERR', 'The shortcode <code>' . $this->shortcodeName . '</code> can only be used once per page!');
            ob_start();
            include DPI_MAPS_DIR . '/Includes/error-max-instances.php';
            return ob_get_clean();
        }
        
        $service = new MapService();
        return $service->makeMap();
    }
    
}