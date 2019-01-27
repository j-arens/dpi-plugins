import docReady from './docReady';
import Tabs from './Tabs';

if (!window.hasOwnProperty('Dpi')) {
    window.Dpi = {};
}

window.Dpi.Tabs = function(selector) {
    if (typeof selector === 'undefined') return;
    return new Tabs(selector);
}

docReady(() => {
    if (window.hasOwnProperty('DpiTabQueue') && window.DpiTabQueue.length) {
        while(window.DpiTabQueue.length) {
            const { selector, config } = window.DpiTabQueue.shift();
            window.Dpi.Tabs(selector).options(config);
        }
    }
});