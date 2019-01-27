'use-strict';

/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 * ======================================================================== */

import camelCase from './camelcase';

export default class Router {
    constructor(routes) {
        this.routes = routes;
    }

    /**
     * Invoke route function
     * @param {string} route 
     * @param {function} fn 
     * @param {parameters} args 
     */
    fire(route, fn = 'init', args) {
        if (route !== '' && this.routes[route] && typeof this.routes[route][fn] === 'function') {
            this.routes[route][fn](args);
        }
    }

    /**
     * Format body classes into an array of strings
     * @param {string} className 
     */
    parseBodyClass(className) {
        return className
                .toLowerCase()
                .replace(/-/g, '_')
                .split(/\s+/)
                .map(camelCase);
    }

    /**
     * Run through body classes and fire routes
     */
    loadEvents() {
        // fire common init first
        this.fire('common');

        // fire body class based route
        this.parseBodyClass(document.body.className).forEach(className => {
            console.log('router:', className);
            this.fire(className);
            this.fire(className, 'finalize');
        });

        // fire common finalize last
        this.fire('common', 'finalize');
    }
}