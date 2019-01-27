const dpiBlogArticleCards = (function() {

    let root;

    /**
     * Route click events
     */
    function _handleClick(e) {
        if (e.target.tagName === 'A' && 'dpiBlogPosts' in window && 'dpiBlogViewer' in window) {
            e.preventDefault();
            const idx = parseFloat(e.target.parentNode.parentNode.dataset.articleidx);
            window.dpiBlogViewer.open(idx);
        }
    }

    /**
     * Add event listeners
     */
    function _bindEvents() {
        try {
            root.addEventListener('click', _handleClick);
        } catch(err) {
            console.error('DPI BLOG ARTICLE CARDS: Unable to binde events!', err);
        }
    }

    /**
     * Cache node
     */
    function _cacheDom() {
        root = document.getElementById('dpiBlog-articleCards__root');
    }

    /**
     * Init
     */
    function _main() {
        _cacheDom();
        _bindEvents();
    }

    /**
     * Document ready
     */
    function _ready(fn) {
        if (document.readyState != 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    /**
     * Public methods
     */
    return {
        init() {
            _ready(_main);
        }
    }

})();

dpiBlogArticleCards.init();