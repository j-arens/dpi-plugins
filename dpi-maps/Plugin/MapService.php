<?php namespace DPIMaps\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class MapService {
    
    private $settingsFields = [
        'api_key',
        'center_latitude',
        'center_longitude',
        'marker_latitude',
        'marker_longitude',
        'zoom',
        'ui',
        'scrollwheel',
        'styles',
        'dblclick'
    ];
    
    private function enqueueAssets() {
        wp_enqueue_script(
            'dpi-maps-client-js',
            plugins_url('/Assets/js/client.min.js', DPI_MAPS_ROOT),
            null,
            filemtime(DPI_MAPS_DIR . '/Assets/js/client.min.js'),
            true
        );
    }
    
    private function getSettings() {
        $settings = [];
        
        foreach($this->settingsFields as $setting) {
            $settings[$setting] = get_option('dpi_maps_' . $setting, false) ?: false;
        }
        
        return $settings;
    }
    
    private function localizeSettings() {
        wp_localize_script(
            'dpi-maps-client-js',
            'dpiMapsSettings',
            json_encode($this->getSettings())
        );
    }
    
    public function makeMap() {
        $this->enqueueAssets();
        $this->localizeSettings();
        ob_start();
        include DPI_MAPS_DIR . '/Includes/map-root.php';
        return ob_get_clean();
    }
    
}