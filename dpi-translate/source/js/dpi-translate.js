window.dpiTranslate = (function() {

    let googleServices,
        targetLangauge,
        toggle,
        langSelect;

    const state = {
        ie: !(window.ActiveXObject) && 'ActiveXObject' in window,
        translateActive: false
    }

    /**
     * Emit onTranslate event from the parentNode
     */
    function _emitTranslateEvent() {
        if (state.ie) {
            const e = document.createEvent('onTranslate');
            e.initCustomEvent('onTranslate', true, true);
            toggle.dispatchEvent(e);
        } else {
            toggle.dispatchEvent(new CustomEvent('onTranslate'));
        }
    }

    /**
     * Fire neccessary events to get google to translate the page - IE compat.
     */
    function _toggleTranslationIE() {
        if (state.translateActive) {
            const iframe = document.querySelector('.goog-te-banner-frame');
            const innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
            const closeLink = innerDoc.querySelector('.goog-close-link');
            const e = document.createEvent('Event');
            e.initEvent('click', true, true);
            closeLink.dispatchEvent(e);
            state.translateActive = false;
        } else {
            const e = document.createEvent('Event');
            e.initEvent('change', true, true);
            langSelect.value = targetLangauge;
            langSelect.dispatchEvent(e);
            state.translateActive = true;
        }
    }

    /**
     * Fire neccessary events to get google to translate the page - web standard
     */
    function _toggleTranslation() {
        if (state.translateActive) {
            const iframe = document.querySelector('.goog-te-banner-frame');
            const innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
            const closeLink = innerDoc.querySelector('.goog-close-link');
            closeLink.dispatchEvent(new Event('click'));
            state.translateActive = false;
        } else {
            langSelect.value = targetLangauge;
            langSelect.dispatchEvent(new Event('change'));
            state.translateActive = true;
        }
    }

    /**
     * Invoke browser compatible function to translate the page and emit onTranslate event
     */
    function _handleTranslateToggle() {
        if (state.ie) {
            _toggleTranslationIE();
        } else {
            _toggleTranslation();
        }

        _emitTranslateEvent();
    }

    /**
     * Setup event listeners
     */
    function _bindEvents() {
        try {
            toggle.addEventListener('click', _handleTranslateToggle);
        } catch (err) {
            console.error('DPI TRANSLATE: Unable to bind events!', err);
        }
    }

    /**
     * Cache important selectors
     */
    function _cacheDom() {
        googleServices = document.getElementById('dpiTranslate__google-services');
        langSelect = googleServices.querySelector('select');
    }

    /**
     * Google translate services callback
     */
    window._initTranslateElement = function() {
        new google.translate.TranslateElement({pageLanguage: 'en'}, 'dpiTranslate__google-services');
        _cacheDom();
        _bindEvents();
    }

    /**
     * Kick things off
     */
    function _initTranslateServices() {
        const script = document.createElement('script');

        document.body.insertAdjacentHTML('beforeend', `
            <div id="dpiTranslate__google-services" style="display: none !important; pointer-events: none !important;"></div>
        `);

        script.setAttribute('type', 'text/javascript');
        script.setAttribute('src', '//translate.google.com/translate_a/element.js?cb=_initTranslateElement');
        document.head.appendChild(script);

        document.head.insertAdjacentHTML('beforeend', `
            <style>

                #goog-gt-tt {
                    display: none !important;
                    pointer-events: none !important;
                }

            </style>
        `);
    }

    /**
     * DOM ready
     * @param {function} fn 
     */
    function _ready(fn) {
        if (document.readyState != 'loading'){
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    /**
     * Public methods
     */
    return {
        init(config) {
            toggle = config.toggle || false;
            targetLangauge = config.targetLangauge || 'en';
            _ready(_initTranslateServices);
        }
    }

})();

/**
 * Emit ready event when loaded
 */
if (!(window.ActiveXObject) && 'ActiveXObject' in window) {
    const e = document.createEvent('dpiTranslateLoaded');
    e.initCustomEvent('dpiTranslateLoaded', true, true);
    window.dispatchEvent(e);
} else {
    window.dispatchEvent(new CustomEvent('dpiTranslateLoaded'));
}
