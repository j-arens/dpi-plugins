'use-strict';

import { debounce } from 'lodash';

const myParishAppSlider = ((posts) => {

    let range = 4;

    let dom = {
        root: null,
        sliderControls: null,
        sliderUl: null,
        sliderItems: null
    };

    /**
     * Slide composition
     * @param {object} state 
     */
    const replace = (state) => {

        // slide animate fn
        const _animateSlide = (node) => {
            node.classList.add('myparishapp__messages-item_hover');
            setTimeout(() => {
                node.classList.remove('myparishapp__messages-item_hover');
            }, 300);
        }

        // slide markup fn
        const _generateMarkup = (message) => {
            return `
                <time class="myparishapp__messages-item_time" datetime="${message.post_date}">
                    ${message.post_date}
                </time>
                <p class="myparishapp__messages-item_content">
                    ${message.post_content}
                </p>
                <a href="${message.permalink}" class="myparishapp__messages-item_link">
                    View Message
                </a>
            `;
        }

        // slide render fn
        const _renderSlide = (node, idx, animate = false) => {
            if (state.messages[idx]) {
                node.dataset.id = state.messages[idx].ID;
                node.innerHTML = _generateMarkup(state.messages[idx]);
                node.classList.remove('myparishapp__messages-item_disabled');
                if (animate) _animateSlide(node);
            } else {
                node.dataset.id = ''
                node.innerHTML = ''
                node.classList.add('myparishapp__messages-item_disabled');
            }
        }

        // interface
        return {
            slide() {
                dom.sliderUl.classList.add('myparishapp__fx-fadeIn');

                state.listItems.forEach((item, i) => {
                    setTimeout(() => {
                        _renderSlide(item, i, true);
                    }, (250 / range) * i);
                });

                setTimeout(() => {
                    dom.sliderUl.classList.remove('myparishapp__fx-fadeIn');
                }, 250);

                return this;
            },
            reset() {
                state.listItems.forEach((item, i) => {
                    _renderSlide(item, i);
                });

                dom.sliderControls[0].classList.add('myparishapp__control-disabled');
                dom.sliderControls[1].classList.remove('myparishapp__control-disabled');

                return this;
            }
        }
    }

    /**
     * Query composition
     * @param {object} state 
     */
    const query = (state) => {

        // slice posts fn
        const _slicePosts = (begin, end) => {
            return posts.slice(begin, end);
        }

        // interface
        return {
            older() {
                dom.sliderControls.forEach(ctrl => ctrl.classList.remove('myparishapp__control-disabled'));
                const furthestValidSlide = [...state.listItems].filter(item => item.dataset.id !== '').pop();
                const begin = posts.findIndex(post => post.ID === parseInt(furthestValidSlide.dataset.id)) + 1;
                const end = begin + range;

                if (end >= posts.length) {
                    state.messages = _slicePosts(begin, posts.length);
                    dom.sliderControls[1].classList.add('myparishapp__control-disabled');
                } else {
                    state.messages = _slicePosts(begin, end);
                }

                return this;
            },
            newer() {
                dom.sliderControls.forEach(ctrl => ctrl.classList.remove('myparishapp__control-disabled'));
                const begin = (posts.findIndex(post => post.ID === parseInt(state.listItems[0].dataset.id))) - range;
                const end = begin + range;

                if (begin <= 0) {
                    state.messages = _slicePosts(0, range);
                    dom.sliderControls[0].classList.add('myparishapp__control-disabled');
                } else {
                    state.messages = _slicePosts(begin, end);
                }

                return this;
            }
        }
    }

    /**
     * Slider constructor
     * @param {array} messages 
     * @param {nodelist or array} listItems 
     */
    const slider = (messages, listItems) => {
        const state = {
            messages,
            listItems
        }

        return Object.assign(
            {},
            state,
            query(state),
            replace(state)
        );
    }

    /**
     * Route click events
     * @param {event obj} e 
     */
    const handleClick = (e) => {
        switch (e.target.dataset.action) {
            case 'SLIDE_LEFT':
                return slider(posts, dom.sliderItems).newer().slide();
            case 'SLIDE_RIGHT':
                return slider(posts, dom.sliderItems).older().slide();
        }
    }

    /**
     * Set the range based off of window width
     */
    const setRange = () => {
        const width = window.innerWidth;

        if (width >= 1300) {
            range = 4;
        } else if (width >= 900 && width < 1300) {
            range = 3;
        } else if (width >= 768 && width < 900) {
            range = 2;
        } else {
            range = 1;
        }

        if (dom.sliderItems) {
            slider(posts, dom.sliderItems).reset();
        }
    }

    /**
     * Setup event listeners
     */
    const bindEvents = () => {
        try {
            window.addEventListener('resize', debounce(setRange, 50));
            dom.root.addEventListener('click', handleClick);
        } catch(err) {
            console.error('MYPARISHAPP_SLIDER: Unable to bind events!', err);
        }
    }

    /**
     * Cache working nodes
     */
    const cacheDom = () => {
        let { root, sliderControls, sliderUl, sliderItems } = dom;
        root = document.getElementById('myparishapp__root');
        sliderControls = root.querySelectorAll('.myparishapp__control');
        sliderUl = root.querySelector('.myparishapp__messages');
        sliderItems = sliderUl.querySelectorAll('.myparishapp__messages-item');
        dom = Object.assign({root, sliderControls, sliderUl, sliderItems});
    }

    /**
     * Dom ready
     * @param {function} fnx 
     */
    const ready = (...fnx) => {
        if (document.readyState != 'loading') {
            fnx.forEach(fn => fn());
        } else {
            document.addEventListener('DOMContentLoaded', () => fnx.forEach(fn => fn()));
        }
    }

    /**
     * Public
     */
    return {
        init() {
            if (posts) {
                ready(setRange, cacheDom, bindEvents);
            } else {
                console.error('MYPARISHAPP_SLIDER: No posts!');
            }
        }
    }

})(window.myParishAppPosts);

myParishAppSlider.init();