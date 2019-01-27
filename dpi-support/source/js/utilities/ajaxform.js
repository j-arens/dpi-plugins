'use-strict';

export default class AjaxForm {
    /**
     * Create new xhr post request object and return it
     * @param {string} url 
     */
    newPostRequest(url) {
        if (!url) return;
        const req = new XMLHttpRequest();
        req.open('POST', url, true);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        return req;
    }

    /**
     * Wrap xhr post request in a promise and return it
     * @param {object} req 
     * @param {object} data 
     */
    promisify(req, data) {
        if (!req) return;
        return new Promise((resolve, reject) => {
            req.onload = () => {
                if (req.status >= 200 && req.status < 300) {
                    resolve(req.response);
                } else {
                    reject({
                        status: req.status,
                        statusText: req.statusText,
                        response: req.response
                    });
                }
            }

            req.onerror = () => {
                reject({
                    status: req.status,
                    statusText: req.statusText,
                    response: req.response
                });
            }

            req.send(JSON.stringify(data));
        });
    }

    /**
     * Create and send off a xhr post request
     * @param {object} config 
     */
    send({ url, data }) {
        if (!url) return false;
        const req = this.newPostRequest(url);
        return this.promisify(req, data);
    }
}