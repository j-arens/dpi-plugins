'use-strict';

const dpiPluginPage = (function($) {

    let $root,
        $colorFields;

    /**
     * Init the wp color picker
     */
    const initColorPicker = () => {
        $colorFields.wpColorPicker({palettes: true});
    }

    /**
     * Cache nodes
     */
    const cacheDom = () => {
        $root = $('#dpiPluginPage__root');
        $colorFields = $root.find('.dpiPluginPage__color');
    }

    /**
     * Main
     */
    const main = () => {
        cacheDom();
        initColorPicker();
    }

    return {
        init() {
            $(document).ready(main);
        }
    }

})(window.jQuery);

dpiPluginPage.init();