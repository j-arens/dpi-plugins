'use-strict';

/* eslint-disable */

/**
 * Transform an object into an observable
 * @param {object} obj 
 */
export function Observable(obj) {
    if (typeof obj !== 'object') {
        console.error('Only objects can be made observable.');
        return;
    }

    this.__store = {};

    /**
     * Register a handler with on observable property
     * @param {string} prop
     * @param {function} handler
     */
    this.addObserver = (prop, handler) => {
        if (!this.__store[prop]) this.__store[prop] = [];
        this.__store[prop].push(handler);
    }

    /**
     * Remove a registered handler
     * @param {string} prop
     * @param {function} handler
     */
    this.removeObserver = (prop, handler) => {
        if (!this.__store[prop]) return;
        const index = this.__store[prop].findIndex(handler => handler === handler);
        this.__store[prop].splice(index, 1);
    }

    /**
     * Run handlers when an observed property is changed
     * @param {string} prop 
     */
    const emitChange = (prop) => {
        if (!this.__store[prop] || this.__store[prop].length < 1) return;
        this.__store[prop].forEach(handler => handler());
    }

    /**
     * Decorate object properties with setters and getters
     * @param {object} obj 
     * @param {string} prop 
     */
    const decorate = (obj, prop) => {
        let val = obj[prop];
        Object.defineProperty(obj, prop, {
            get () {
                return val;
            },
            set (newVal) {
                val = newVal;
                emitChange.call(obj, prop);
            }
        });
    }

    /**
     * Turn a plain object into an object with observable properties
     * @param {object} obj 
     */
    const makeObservable = (obj) => {
        Object.keys(obj).forEach(key => decorate(obj, key));
        return obj;
    }

    return Object.assign(makeObservable(obj), this);
}