window.dpiBlogViewer = (function(posts) {

    const state = {
        active: false,
        currentArticle: 0,
        dom: {
            root: null,
            container: null
        }
    }

    /**
     * Reset state, close the viewer
     */
    function _terminate() {
        if (state.active) {
            document.body.removeChild(state.dom.root);

            state.active = false;
            state.currentArticle = 0;

            for (let node in state.dom) {
                state.dom[node] = null;
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * Scroll to the top of the page
     */
    function _scrollToTop() {
        if (state.dom.root.scrollTop !== 0) {
            if (window.innerWidth <= 700) {
                state.dom.root.scrollTop-= 200;
            } else {
                state.dom.root.scrollTop-= 100;
            }
            requestAnimationFrame(_scrollToTop);
        } else {
            cancelAnimationFrame(window.dpiBlogViewerAnimationID);
            state.dom.container.classList.remove('dpiBlog-viewer__fx-hide');
        }
    }

    /**
     * Re-render the article
     */
    function _reRender(action) {
        if (state.active) {
            if (action === 'next' && state.currentArticle !== posts.length - 1) {
                state.currentArticle++;
                _renderArticle();
            } else if (action === 'prev' && state.currentArticle !== 0) {
                state.currentArticle--;
                _renderArticle();
            }
        } else {
            return false;
        }

        state.dom.container.classList.add('dpiBlog-viewer__fx-hide');
        window.dpiBlogViewerAnimationID = requestAnimationFrame(_scrollToTop);
        return true;
    }

    /**
     * Route Events
     */
    function _handleClick(e) {
        if (e.target.dataset.action) {
            switch (e.target.dataset.action) {
                case 'close':
                    return _terminate();
                case 'prev':
                    return _reRender('prev');
                case 'next':
                    return _reRender('next');
            }
        }
    }

    /**
     * Generate the markup for an article control
     */
    function _generateArticleControl(action) {
        if ((action === 'prev' && state.currentArticle !== 0) || (action === 'next' && state.currentArticle !== posts.length -1)) {
            return `
                <button class="dpiBlog-viewer__nav-btn" data-action="${action}">
                    <svg class="dpiBlog-viewer__nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 75.6 57.9">
                        <path d="M4.5 33.4h55.8L43.5 50.2c-1.8 1.8-1.8 4.6 0 6.4 1.8 1.8 4.6 1.8 6.4 0l24.4-24.4c0.8-0.8 1.3-2 1.3-3.2s-0.5-2.3-1.3-3.2L49.9 1.3C49 0.4 47.9 0 46.7 0s-2.3 0.4-3.2 1.3c-1.8 1.8-1.8 4.6 0 6.4L60.3 24.4H4.5c-2.5 0-4.5 2-4.5 4.5C0 31.4 2 33.4 4.5 33.4z"/>
                    </svg>
                    <p class="dpiBlog-viewer__nav-title">
                        ${action === 'prev' ? posts[state.currentArticle - 1].title : posts[state.currentArticle + 1].title}
                    </p>
                </button>
            `;
        }

        return '';
    }

    /**
     * Convert idx into month string
     */
    function _convertIdxToMonth(idx) {
        switch (idx) {
            case 0:
                return 'January';
            case 1:
                return 'February';
            case 2:
                return 'March';
            case 3:
                return 'April';
            case 4:
                return 'May';
            case 5:
                return 'June';
            case 6:
                return 'July';
            case 7:
                return 'August';
            case 8:
                return 'September';
            case 9:
                return 'October';
            case 10:
                return 'November';
            case 11:
                return 'December';
        }
    }

    /**
     * Parse date string into M/dd/yyyy
     */
    function _formatDate(str) {
        const date = new Date(str);
        return `${_convertIdxToMonth(date.getMonth())} ${date.getDate()}, ${date.getFullYear()}`;
    }

    /**
     * Render out an article
     */
    function _renderArticle() {
        const post = posts[state.currentArticle];
        state.dom.container.innerHTML = `
            <article class="dpiBlog-viewer__article">
                <time class="dpiBlog-viewer__article-date">${_formatDate(post.date)}</time>
                <h1 class="dpiBlog-viewer__article-title">${post.title}</h1>
                <figure class="dpiBlog-viewer__article-img">
                    <div class="dpiBlog-viewer__article-img-placeholder" style="background-image: url(${post.imageURL})"></div>
                </figure>
                <div class="dpiBlog-viewer__article-content">
                    ${post.content}
                    <p class="dpiBlog-viewer__copyright">
                        &copy; 2017 <a href="https://diocesan.com" class="dpiBlog-viewer__copyright-link">Diocesan Publications</a>
                    </p>
                </div>
                <nav class="dpiBlog-viewer__nav">
                    ${_generateArticleControl('prev')}
                    ${_generateArticleControl('next')}
                </nav>
            </article>
        `;
    }

    /**
     * Setup event listeners
     */
    function _bindEvents() {
        try {
            state.dom.root.addEventListener('click', _handleClick);
        } catch(err) {
            console.error('DPI BLOG VIEWER: Unable to bind events!', err);
        }
    }

    /**
     * Cache nodes
     */
    function _cacheDom() {
        state.dom.root = document.getElementById('dpiBlog-viewer__root');
        state.dom.container = state.dom.root.querySelector('.dpiBlog-viewer__container');
    }

    /**
     * Render out the viewer root
     */
    function _renderRoot() {
        document.body.insertAdjacentHTML('beforeend', `
            <div id="dpiBlog-viewer__root" class="dpiBlog-viewer__fx-transition">
                <button class="dpiBlog-viewer__close-btn" data-action="close">
                    <svg class="dpiBlog-viewer__close-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 62.4 62.4">
                        <path d="M39.7 31.2l21-21c2.3-2.3 2.3-6.1 0-8.5 -2.3-2.3-6.1-2.3-8.5 0L31.2 22.7 10.2 1.8C7.9-0.6 4.1-0.6 1.8 1.8c-2.3 2.3-2.3 6.1 0 8.5L22.7 31.2 1.8 52.2c-2.3 2.3-2.3 6.1 0 8.5C2.9 61.8 4.5 62.4 6 62.4s3.1-0.6 4.2-1.8L31.2 39.7l21 21c1.2 1.2 2.7 1.8 4.2 1.8s3.1-0.6 4.2-1.8c2.3-2.3 2.3-6.1 0-8.5L39.7 31.2z"/>
                    </svg>
                    Close
                </button>
                <div class="dpiBlog-viewer__container"></div>
            </div>
        `);
    }

    /**
     * Kick it off
     */
    function _init(idx) {
        if (!state.active && posts) {
            state.active = true;
            state.currentArticle = idx;
            _renderRoot();
            _cacheDom();
            _bindEvents();
            _renderArticle();
        } else {
            return false;
        }

        return true;
    }

    /**
     * Public methods
     */
    return {
        open(idx = 0) {
            return _init(idx);
        },
        close() {
            return _terminate();
        },
        prevArticle() {
            return _reRender('prev');
        },
        nextArticle() {
            return _reRender('next');
        }
    }

})(JSON.parse(window.dpiBlogPosts));