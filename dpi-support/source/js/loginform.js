'use-strict';

import { Observable } from './utilities/observable';
import AjaxForm from './utilities/ajaxform';

export default class LoginForm extends AjaxForm {
    constructor() {
        super();
        
        this.state = new Observable({
            status: 'idle',
            root: null,
            icons: null,
            inputs: null,
            submitBtn: null
        });

        this.cacheDom();
        this.bindObservers();
        this.bindEvents();
    }

    /**
     * Cache working nodes
     */
    cacheDom() {
        const state = this.state;
        state.root = document.getElementById('loginform-js');
        state.icons = state.root.querySelectorAll('.login-form--icon-js');
        state.inputs = state.root.querySelectorAll('.login-form--input-group-js input');
        state.submitBtn = state.root.querySelector('.login-form--submit-btn-js');
    }

    /**
     * Bind state observers
     */
    bindObservers() {
        this.state.addObserver('status', this.toggleSpinner.bind(this));
    }

    /**
     * Bind dom events
     */
    bindEvents() {
        const { inputs, root } = this.state;

        try {
            root.addEventListener('submit', this.handleSubmit.bind(this));
            inputs.forEach(input => {
                input.addEventListener('focus', this.resetInput);
            });
        } catch(err) {
            console.error('Login Form: Unable to bind events!', err);
        }
    }

    /**
     * Reset an input to it's original state
     */
    resetInput() {
        this.classList.remove('input__is-invalid');
    }

    /**
     * Reactive, toggles spinner when form state = submitting
     */
    toggleSpinner() {
        if (this.state.status === 'submitting') {
            this.state.icons[0].classList.add('c-login-form--icon__is-hidden');
            this.state.icons[1].classList.remove('c-login-form--icon__is-hidden');
        } else {
            this.state.icons[0].classList.remove('c-login-form--icon__is-hidden');
            this.state.icons[1].classList.add('c-login-form--icon__is-hidden');
        }
    }

    /**
     * Validate inputs, reflect errors to the user
     */
    validateInputs() {
        let isValid = true;

        this.state.inputs.forEach(input => {
            if (!input.value) {
                isValid = false;
                input.classList.add('input__is-invalid');
            }
        });

        if (!isValid) {
            if (!this.invalidFlash_id) {
                this.invalidFlash_id = window.Flash.alert({
                    type: 'danger',
                    message: 'Please fill out both fields before submitting.',
                    dismissable: true
                });
            } else {
                window.Flash.show(this.invalidFlash_id);
            }
        }

        return isValid;
    }

    /**
     * Submit the form & redirect if valid, reflect state to the user
     * @param {event} e 
     */
    handleSubmit(e) {
        e.preventDefault();
        if (this.state.status !== 'submitting' && this.validateInputs()) {
            this.state.status = 'submitting';

            this.send({
                url: window.location.href,
                data: {
                    nonce: this.state.root.querySelector('#nonce').value,
                    username: this.state.inputs[0].value,
                    password: this.state.inputs[1].value
                }
            }).then(() => {
                window.location.replace(window.location.pathname.replace(/(login\/?)$/, ''));
            }).catch(res => {
                this.state.status = 'idle';
                const response = JSON.parse(res.response);
                const message = response.returnMessage || 'Uh oh, there was an error. Please refresh the page and try again.'
                if (!this.errorFlash_id) {
                    this.errorFlash_id = window.Flash.alert({
                        type: 'danger',
                        dismissable: true,
                        message
                    });
                } else {
                    window.Flash.show(this.errorFlash_id);
                }
            });
        }
    }
}