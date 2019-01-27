'use-strict';

// js entrypoint
import Flash from './utilities/flash';
import Router from './utilities/router';
import common from './routes/common';
import login from './routes/login';

/**
 * Routes
 */
const routes = {
    common,
    login
};

/**
 * Document ready
 * @param {function} fnx 
 */
const docReady = (...fnx) => {
    if (document.readyState != 'loading') {
        fnx.forEach(fn => fn());
    } else {
        document.addEventListener('DOMContentLoaded', () => fnx.forEach(fn => fn()));
    }
}

// run it
window.Flash = new Flash();
docReady(() => new Router(routes).loadEvents());