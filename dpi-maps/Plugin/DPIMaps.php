<?php namespace DPIMaps\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPIMaps {
    
    private $shortcodeName = 'dpi_map';
    
    public function init() {
        if (is_admin()) {
            $pluginPage = new PluginPage();
            $pluginPage->register();
        } else {
            $shortcode = new Shortcode($this->shortcodeName);
            $shortcode->register();
        }
    }
    
    public static function install() {
        update_option('dpi_maps_api_key', 'AIzaSyCYCgRB1M8tpaZ3KFjs3XM2nH2u_hhuppA');
        update_option('dpi_maps_ui', 'on');
        update_option('dpi_maps_scrollwheel', 'on');
        update_option('dpi_maps_dblclick', 'on');
    }
    
}