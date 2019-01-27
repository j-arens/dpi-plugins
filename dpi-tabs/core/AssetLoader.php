<?php namespace DpiTabs\core;

class AssetLoader implements LoaderInterface {
    
    /**
     * Enqueue's a stylesheet with WP
     * 
     * @param array $stylesheet
     * @return string
     */
    public function enqueueStyle(array $stylesheet) {
        if (empty($stylesheet)) {
            return false;
        }

        $dependencies = key_exists('dependencies', $stylesheet) ? $stylehseet['dependencies'] : null;
        $media = key_exists('media', $stylesheet) ? $stylesheet['media'] : 'all';

        $loaded = wp_enqueue_style(
            $stylesheet['id'],
            $stylesheet['url'],
            $dependencies,
            filemtime($stylesheet['path']),
            $media
        );

        if (!$loaded) {
            return false;
        }

        return $stylesheet['id'];
    }

    /**
     * Enqueue's a script with WP
     * 
     * @param array $script
     * @return string
     */
    public function enqueueScript(array $script) {
        if (empty($script)) {
            return false;
        }

        $dependencies = key_exists('dependencies', $script) ? $script['dependencies'] : null;
        $location = key_exists('location', $script) ? $script['location'] : 'footer';

        $loaded = wp_enqueue_script(
            $script['id'],
            $script['url'],
            $dependencies,
            filemtime($script['path']),
            $location === 'footer' ? true : false
        );

        if (!$loaded) {
            return false;
        }

        return $script['id'];
    }

}