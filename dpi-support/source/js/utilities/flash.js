'use-strict';

export default class Flash {
    constructor() {
        this.instances = 0;
        this.messages = [];
    }

    /**
     * Inject root ul onto page
     */
    injectRoot() {
        document.body.insertAdjacentHTML('beforeend', `<ul id="flash-js" class="c-flash"></ul>`);
        this.root = document.getElementById('flash-js');
    }

    /**
     * Return the markup for a close button
     */
    button() {
        return `
            <button class="c-flash--close-btn" onclick="(function() {Flash.hide(this.event.target.parentElement.dataset.flash_id)})()">
                <svg class="c-flash--close-btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M14.59 8L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8zM12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </button>
        `;
    }

    /**
     * Inject a flash message onto the page
     * @param {Object} flashMessage
     */
    injectFlashMessage({ type, message, dismissable, hideAfter, id }) {
        if (!this.root) this.injectRoot();

        this.root.insertAdjacentHTML('beforeend', `
            <li class="c-flash--message ${type ? `c-flash__${type}` : ''}" data-flash_id="${id}">
                ${dismissable ? this.button() : ''}
                <p class="c-flash--content">${message}</p>
            </li>
        `);

        if (hideAfter) {
            setTimeout(this.hide.bind(this, id), hideAfter);
        }
    }

    /**
     * Remove root ul from page if it has no children
     */
    removeRootIfEmpty() {
        if (!this.root.children.length) {
            document.body.removeChild(this.root);
            this.root = null;
        }
    }

    /**
     * Remove a flash message from the page
     * @param {Dom node} node 
     */
    removeFlashMessage(node) {
        if (!this.root) return;

        try {
            this.root.removeChild(node);
        } catch(err) {
            console.error(`Flash: Unable to query flash message for removal. `, err);
        }

        this.removeRootIfEmpty();
    }

    /**
     * Show a stored message if it's not already on the page
     * @param {string, number} id 
     */
    show(id) {
        if (!id) return;

        if (typeof id !== 'number') {
            id = parseInt(id);
        }

        const flashMessage = this.messages.filter(message => message.id === id)[0];
        if (!flashMessage) return;

        if (!this.root) {
            this.injectRoot();
            this.injectFlashMessage(flashMessage);
        } else {
            if (this.root.querySelector(`[data-flash_id="${id}"]`)) return;
            this.injectFlashMessage(flashMessage);
        }
    }

    /**
     * Hide a flashmessage if it's on the page, then remove it
     * @param {string, number} id 
     */
    hide(id) {
        if (!id) return;

        if (typeof id !== 'number') {
            id = parseInt(id);
        }

        if (!this.root) return;

        const node = this.root.querySelector(`[data-flash_id="${id}"]`);

        if (node) {
            node.classList.add('c-flash--message__is-hidden');
            setTimeout(this.removeFlashMessage.bind(this, node), 200);
        }
    }

    /**
     * Create new flashmessage, return an id for reference
     * @param {object} flashmessage
     */
    alert({ type = '', message = '', dismissable = true, hideAfter = '' }) {
        this.instances = this.instances + 1;
        const flashMessage = {type, message, dismissable, hideAfter, id: this.instances};
        this.messages.push(flashMessage);
        this.injectFlashMessage(flashMessage);
        return this.instances;
    }
}