<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Translate {

    public function init() {
        add_shortcode('dpi_translate', [$this, 'shortcodeHandler']);
        $this->enqueueAssets();
    }

    public function enqueueAssets() {
        if (!is_admin()) {
            wp_enqueue_script(
                'dpi-translate-js', 
                plugins_url('../js/dpi-translate.min.js', __FILE__), 
                null, 
                filemtime(plugin_dir_path(dirname(__FILE__)) . 'js/dpi-translate.min.js'), 
                false
            );
        }
    }

    public function generateScript($lang) {
        return '
            <script data-dpiTranslateRoot>
                function dpiTranslateInit() {
                    window.dpiTranslate.init({
                        toggle: document.querySelector("[data-dpiTranslateRoot]").parentNode,
                        targetLangauge: "' . $lang . '"
                    });
                }

                if (window.dpiTranslate) {
                    dpiTranslateInit();
                } else {
                    window.addEventListener("dpiTranslateLoaded", dpiTranslateInit);
                }
            </script>
        ';
    }

    public function shortcodeHandler($atts) {
        $targetLangauge = array_key_exists('langauge', $atts) ? sanitize_text_field($atts['langauge']) : 'en';
        return $this->generateScript($targetLangauge);
    }
}