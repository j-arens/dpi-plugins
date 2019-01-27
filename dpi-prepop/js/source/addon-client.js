(function($) {

    if (!window.hasOwnProperty('dpi')) {
        window.dpi = {};
    }

    window.dpi.prePop = function(node) {

        if (typeof node === undefined) return;

        /**
         * PrePop constructor
         * @param {dom node} node 
         */
        const prePop = function(node) {
            this.input = node;
            this.populateInput();
        }

        /**
         * Request the appropiate value from the api
         * @param {string} type
         * @return {boolean/jquery promise} return false if missing required items, otherwise returns jquery promise
         */
        prePop.prototype.getValue = function(type) {
            if (!type || !window.hasOwnProperty('wpApiSettings')) {
                this.input.value = '';
                this.input.setAttribute('value', '');
                return false;
            }

            return $.ajax({
                url: window.wpApiSettings.root + 'dpi/v1/pre-populate',
                method: 'GET',
                data: {type},
                headers: {'X-WP-Nonce': window.wpApiSettings.nonce}
            });
        }

        /**
         * Transform input value into the correct data
         */
        prePop.prototype.populateInput = function() {
            const type = this.input.dataset.dpiprepop;

            this.getValue(type)
                .success((res) => {
                    const val = JSON.parse(res)[type];
                    this.input.value = val;
                    this.input.setAttribute('value', val);
                })
                .fail((res) => {
                    this.input.value = '';
                    this.input.setAttribute('value', '');
                    console.error('DPI_PRE_POP: Unable to retrieve ' + type + ' !', res);
                });
        }

        return new prePop(node);
    }

    if (window.hasOwnProperty('prePopQueue')) {
        while(window.prePopQueue.length) {
            window.dpi.prePop(window.prePopQueue.pop());
        }
    }

})(jQuery);