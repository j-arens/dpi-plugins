// @ts-check

const config = {
    breakpoints: {
        mobile: 768
    },
    classes: {
        tab: 'dpi-tab__tab',
        navItem: 'dpi-tab__nav-item',
        tabActive: 'dpi-tab__tab-is-active',
        navItemActive: 'dpi-tab__nav-item-is-active',
        contentContainer: 'dpi-tab__content'
    }
}

export default class Tabs {
    constructor(selector) {
        this.selector = selector;
        this.currentTab  = 0;
        this.root = null;
        this.navItems = null;
        this.tabs = null;
        this.hashNavigation = true;
        this.animationClass = 'dpiFadeIn';
        this.callback = null;

        if (this.cacheDom()) {
            this.bindEvents();
            this.initAria();
            this.loadFromHash();
        }
    }

    /**
     * Configure Tab options
     * @param {object} config options
     * @returns {object} Tabs 
     */
    options({ hash_navigation = true, animation_class, callback }) {
        this.hashNavigation = (hash_navigation === true || hash_navigation == 'true' ? true : false); // comparing a string because php's json_encode will turn booleans to strings

        if (animation_class && typeof animation_class === 'string') {
            this.animationClass = animation_class;
        }

        if (typeof callback === 'function') {
            this.callback = callback;
        }

        return this;
    }

    /**
     * Get the current environment context based on window width
     */
    getContext() {
        const windowWidth = window.innerWidth;
        const { mobile } = config.breakpoints;

        if (windowWidth < mobile) {
            return 'mobile';
        } else {
            return 'desktop';
        }
    }

    /**
     * Set a hash in the url for the selected tab
     * @param {number} index 
     */
    setHash(index = 0) {
        if (!this.hashNavigation) return;

        const hash = `#${this.root.id}&tab=${this.tabs[index].id}`;
        window.history.replaceState({}, '', hash);
    }

    /**
     * Set the aria selected attribute on a tab
     * @param {number} index 
     * @param {boolean} state 
     */
    ariaSelected(index = 0, state) {
        this.tabs[index].setAttribute('aria-selected', state);
    }

    /**
     * Append the active class to a tab
     * @param {number} index 
     */
    appendActiveToTab(index = 0) {
        this.tabs[index].classList.add(config.classes.tabActive);
    }

    /**
     * Remove the active class from a tab
     * @param {number} index 
     */
    removeActiveFromTab(index = 0) {
        this.tabs[index].classList.remove(config.classes.tabActive);
    }

    /**
     * Append the active class to a nav item
     * @param {number} index 
     */
    appendActiveToNavItem(index = 0) {
        this.navItems[index].classList.add(config.classes.navItemActive);
    }

    /**
     * Remove the active class from a nav item
     * @param {number} index 
     */
    removeActiveFromNavItem(index = 0) {
        this.navItems[index].classList.remove(config.classes.navItemActive);
    }

    /**
     * Append the animation class to a tab content container
     * @param {number} index 
     */
    appendAnimationClass(index = 0) {
        const contentContainer = this.tabs[index].querySelector(`.${config.classes.contentContainer}`);
        contentContainer.classList.add(this.animationClass);
    }

    /**
     * Remove the animation class from a tab content container
     * @param {number} index 
     */
    removeAnimationClass(index = 0) {
        const contentContainer = this.tabs[index].querySelector(`.${config.classes.contentContainer}`);
        contentContainer.classList.remove(this.animationClass);
    }

    /**
     * Check if the tab content container currently has the animation class
     * @param {number} index 
     */
    hasAnimationClass(index = 0) {
        const contentContainer = this.tabs[index].querySelector(`.${config.classes.contentContainer}`);
        return contentContainer.classList.contains(this.animationClass);
    }

    /**
     * Gets the current context and handles toggling a new tab
     * @param {number} index 
     */
    toggleTab(index = 0) {
        if (this.tabs[index] === 'undefined') return;

        switch(this.getContext()) {

            case 'mobile':
            
                if (this.currentTab === index) {
                    this.removeActiveFromTab(this.currentTab);
                    this.ariaSelected(this.currentTab, false);

                    if (this.hasAnimationClass(this.currentTab)) {
                        this.removeAnimationClass(this.currentTab);
                    }

                    this.currentTab = null;

                } else {

                    if (this.currentTab !== null) {
                        this.removeActiveFromTab(this.currentTab);
                        this.ariaSelected(this.currentTab, false);

                        if (this.hasAnimationClass(this.currentTab)) {
                            this.removeAnimationClass(this.currentTab);
                        }
                    }

                    this.appendActiveToTab(index);
                    this.appendAnimationClass(index);
                    this.ariaSelected(index, true);
                    this.setHash(index);

                    this.currentTab = index;
                }

                if (this.callback) {
                    this.callback.call(this);
                }

                break;

            case 'desktop':

                if (this.currentTab === index) return;

                if (this.currentTab !== null) {
                    this.removeActiveFromNavItem(this.currentTab);
                    this.removeActiveFromTab(this.currentTab);
                    this.ariaSelected(this.currentTab, false);

                    if (this.hasAnimationClass(this.currentTab)) {
                        this.removeAnimationClass(this.currentTab);
                    }
                }

                this.appendActiveToNavItem(index);
                this.appendActiveToTab(index);
                this.appendAnimationClass(index);
                this.ariaSelected(index, true);
                this.setHash(index);

                this.currentTab = index;

                if (this.callback) {
                    this.callback.call(this);
                }

                break;
        }
    }

    /**
     * Route events on the tab component
     * @param {object} e 
     */
    handleACtion(e) {
        const action = e.target.dataset.action;

        if (!action) return;
        
        e.preventDefault();

        switch(action) {
            case 'TOGGLE':
                
                var index = '';

                if (this.getContext() === 'mobile') {
                    index = this.tabs.indexOf(e.target.parentElement).toString();
                } else {
                    index = this.navItems.indexOf(e.target).toString();
                }

                return this.toggleTab(parseInt(index, 10));

            default:
                return false;
        }
    }

    /**
     * Reset the state of tab component based on context when manually resiszing the viewport
     */
    handleResize() {
        let debouncer;

        clearTimeout(debouncer);

        debouncer = setTimeout(() => {
            const context = this.getContext();

            if (context !== 'mobile') {

                if (this.currentTab === null) {
                    return this.toggleTab(0);
                }

                this.appendActiveToNavItem(this.currentTab);

            } else {
                if (this.currentTab !== null) {
                    this.removeActiveFromNavItem(this.currentTab);
                }
            }
        }, 250);
    }

    /**
     * Automatically scroll the page to bring the tab component into view
     */
    focusComponent() {
        const componentTop = this.root.getBoundingClientRect().top;
        const clientTop = document.documentElement.clientTop;
        const yOffset = window.pageYOffset;

        // can't get this to work without the timeout! Tried waiting for readyState === complete,
        // also tried this.root.scrollIntoView(), document.body.scrollTop, & window.scroll(),
        // all of them need the timeout for some reason
        setTimeout(() => {
            window.scrollTo(0, Math.round((componentTop + yOffset - clientTop) + 32));
        }, 1);
    }

    /**
     * Pre-select & focus a component + tab based off a url hash id
     */
    loadFromHash() {
        if (!this.hashNavigation) return;

        const hash = window.location.hash;

        if (hash) {
            const componentMatch = hash.match(/(?!^#)(.*)(?=&tab=.*?)/);
            const tabMatch = hash.match(/(&tab=.*)$/);
            const componentId = componentMatch.length ? componentMatch.shift() : 0;
            const tabId = tabMatch.length ? tabMatch.shift().replace('&tab=', '') : 0;

            if (componentId === this.root.id) {
                this.tabs.forEach((tab , i) => {
                    if (tab.id === tabId) {
                        this.focusComponent();
                        this.toggleTab(i);
                    }
                });
            }
        }
    }

    /**
     * Add aria selected attributes to the tabs
     */
    initAria() {
        this.tabs.forEach((tab, i) => {
            if (tab.classList.contains(config.classes.tabActive)) {
                this.ariaSelected(i, true);
            } else {
                this.ariaSelected(i, false);
            }
        });
    }

    /**
     * Bind event listeners
     */
    bindEvents() {
        this.root.addEventListener('click', this.handleACtion.bind(this));
        window.addEventListener('resize', this.handleResize.bind(this));
        this.tabs.forEach(tab => tab.addEventListener('animationend', () => this.removeAnimationClass(this.currentTab)));
    }

    /**
     * Cache working nodes
     */
    cacheDom() {
        this.root = document.querySelector(this.selector);

        try {
            this.tabs = Array.from(this.root.querySelectorAll(`.${config.classes.tab}`));
            this.navItems = Array.from(this.root.querySelectorAll(`.${config.classes.navItem}`));
            return true;
        } catch(err) {
            console.error('DPI_TABS: Unable to query nodes!', err);
            return false;
        }
    }
}