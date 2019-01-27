import Codemirror from 'codemirror';
require('codemirror/mode/css/css');

const dpiLoginAdmin = (function($, data) {

    let codemirror,
        $colorInputs,
        $imageControls,
        $editorData;

    const state = {
        mediaFrame: false
    }

    function removeImage(context) {
        const $context = $(context.get(0));
        $context.find('.dpi-login-image').attr('src', '');
        $context.find('.dpi-login-image-input').val('');
        $context.find('.dpi-login-image-control[data-action="remove"]').addClass('dpi-login-input-disabled');
    }

    function setImage(data) {
        const $context = $(data.context.get(0));
        $context.find('.dpi-login-image').attr('src', data.imageUrl);
        $context.find('.dpi-login-image-input').val(data.imageID);
        $context.find('.dpi-login-image-control[data-action="remove"]').removeClass('dpi-login-input-disabled');
    }

    function mediaPicker(context) {
        if (!state.mediaFrame) {
            state.mediaFrame = window.wp.media({
                title: 'Insert Image',
                library: {type: 'image'},
                multiple: false,
                button: {text: 'insert'}
            });

            state.mediaFrame.on('select', () => {
                const data = state.mediaFrame.state().get('selection').first().toJSON();
                setImage({
                    context,
                    imageUrl: data.sizes.medium.url,
                    imageID: data.id
                });
            });
        }

        state.mediaFrame.open();
        return false;
    }

    function handleImageControl(e) {
        e.preventDefault();
        const $target = $(e.target);
        const action = $target.attr('data-action');
        const context = $target.closest('.dpi-login-image-container')

        if (action === 'add') {
            mediaPicker(context);
        } else {
            removeImage(context);
        }
    }

    function colorPicker() {
        $colorInputs.wpColorPicker({palettes: true});
    }

    function saveCodemirror() {
        $editorData.val(codemirror.getValue());
    }

    function setCodemirror(data) {
        codemirror = Codemirror.fromTextArea(document.querySelector('.editor'), {
            theme: 'solarized-dark',
            lineNumbers: true,
            mode: 'text/css'
        });

        codemirror.setValue(data.styles);
        codemirror.on('blur', saveCodemirror);
    }

    function bindEvents() {
        try {
            $imageControls.each(function(i, control) {
                $(control).on('click', handleImageControl);
            });
        } catch(err) {
            console.error('DPI Login: Unable to bind events!', err);
        }
    }

    function cacheDom() {
        $editorData = $('#dpi_login_editor_styles');
        $colorInputs = $('.dpi-login-color');
        $imageControls = $('.dpi-login-image-control');
    }

    function init() {
        cacheDom();
        bindEvents();
        colorPicker();

        if (!data) {
            console.error('DPI Login: Unable to get localized data!');
        } else {
            setCodemirror(data);
        }
    }

    return {
        init() {
            $(document).ready(init);
        }
    }

})(jQuery, window.dpiLoginLocal);

dpiLoginAdmin.init();
