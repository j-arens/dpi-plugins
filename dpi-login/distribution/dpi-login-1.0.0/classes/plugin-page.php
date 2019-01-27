<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Login_Plugin_Page {

    private $sections = [
        'general_options' => [
            'id' => 'dpi_login_general_options',
            'title' => ''
        ]
    ];
    private $fields = [
        'advanced_ui' => [
            'id' => 'dpi_login_advanced_ui',
            'title' => 'Use stylesheet editor (disables settings)',
            'section' => 'dpi_login_general_options',
            'input_type' => 'checkbox'
        ],
        'codemirror' => [
            'id' => 'dpi_login_codemirror',
            'title' => '',
            'section' => 'dpi_login_general_options',
            'input_type' => 'codemirror'
        ],
        'editor_styles' => [
            'id' => 'dpi_login_editor_styles',
            'title' => '',
            'section' => 'dpi_login_general_options',
            'input_type' => 'hidden'
        ],
        'body_bg' => [
            'id' => 'dpi_login_body_bg_color',
            'title' => 'Body Background Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'body_img' => [
            'id' => 'dpi_login_body_bg_image',
            'title' => 'Body Background Image',
            'section' => 'dpi_login_general_options',
            'input_type' => 'image'
        ],
        'body_bg_size' => [
            'id' => 'dpi_login_body_bg_size',
            'title' => 'Body Background Image Size %',
            'section' => 'dpi_login_general_options',
            'input_type' => 'number',
            'min' => 0,
            'max' => 100
        ],
        'body_bg_position' => [
            'id' => 'dpi_login_body_bg_position',
            'title' => 'Background Position',
            'section' => 'dpi_login_general_options',
            'input_type' => 'select',
            'options' => [
                'left_top' => 'Left Top',
                'left_center' => 'Left Center',
                'left_bottom' => 'Left Bottom',
                'right_top' => 'Right Top',
                'right_center' => 'Right Center',
                'right_bottom' => 'Right Bottom',
                'center_top' => 'Center Top',
                'center_center' => 'Center Center',
                'center_bottom' => 'Center Bottom'
            ]
        ],
        'logo_bg_image' => [
            'id' => 'dpi_login_logo_bg_image',
            'title' => 'Logo Image',
            'section' => 'dpi_login_general_options',
            'input_type' => 'image'
        ],
        'logo_bg_width' => [
            'id' => 'dpi_login_logo_bg_width',
            'title' => 'Logo Width',
            'section' => 'dpi_login_general_options',
            'input_type' => 'text'
        ],
        'logo_bg_height' => [
            'id' => 'dpi_login_logo_bg_height',
            'title' => 'Logo Height',
            'section' => 'dpi_login_general_options',
            'input_type' => 'text'
        ],
        'logo_bg_size' => [
            'id' => 'dpi_login_logo_bg_size',
            'title' => 'Logo Size %',
            'section' => 'dpi_login_general_options',
            'input_type' => 'number',
            'min' => 0,
            'max' => 100
        ],
        'logo_bg_repeat' => [
            'id' => 'dpi_login_logo_bg_repeat',
            'title' => 'Logo Repeat',
            'section' => 'dpi_login_general_options',
            'input_type' => 'select',
            'options' => [
                'no_repeat' => 'No Repeat',
                'repeat_x' => 'Repeat X',
                'repeat_y' => 'Repeat Y',
                'space' => 'space',
                'round' => 'round'
            ]
        ],
        'logo_link' => [
            'id' => 'dpi_login_logo_link',
            'title' => 'Logo Link',
            'section' => 'dpi_login_general_options',
            'input_type' => 'text'
        ],
        'form_bg_color' => [
            'id' => 'dpi_login_form_bg_color',
            'title' => 'Form Background Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'form_labels_font_size' => [
            'id' => 'dpi_login_form_labels_size',
            'title' => 'Form Labels Font Size',
            'section' => 'dpi_login_general_options',
            'input_type' => 'text'
        ],
        'form_labels_font_color' => [
            'id' => 'dpi_login_form_labels_color',
            'title' => 'Form Labels Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'remember_me_font_size' => [
            'id' => 'dpi_login_rememberme_size',
            'title' => 'Remember Me Font Size',
            'section' => 'dpi_login_general_options',
            'input_type' => 'text'
        ],
        'remember_me_font_color' => [
            'id' => 'dpi_login_rememberme_color',
            'title' => 'Remember Me Font Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'submit_bg_color' => [
            'id' => 'dpi_login_submit_bg_color',
            'title' => 'Submit Background Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'submit_bg_border_color' => [
            'id' => 'dpi_login_submit_border_color',
            'title' => 'Submit Border Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'submit_box_shadow_color' => [
            'id' => 'dpi_login_submit_box_shadow_color',
            'title' => 'Submit Box Shadow Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'submit_text_shadow_color' => [
            'id' => 'dpi_login_submit_text_shadow_color',
            'title' => 'Submit Text Shadow Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'footer_links_font_size' => [
            'id' => 'dpi_login_footer_links_size',
            'title' => 'Footer Links Font Size',
            'section' => 'dpi_login_general_options',
            'input_type' => 'text'
        ],
        'footer_links_font_color' => [
            'id' => 'dpi_login_footer_links_color',
            'title' => 'Footer Links Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ],
        'footer_links_hover_color' => [
            'id' => 'dpi_login_footer_links_hover_color',
            'title' => 'Footer Links Hover Color',
            'section' => 'dpi_login_general_options',
            'input_type' => 'color'
        ]
    ];

    public function __construct() {
        add_action('admin_menu', [$this, 'addPage']);
        add_action('admin_enqueue_scripts', [$this, 'enqueuePageAssets']);
        add_action('admin_init', [$this, 'pageInit']);
    }

    public function addPage() {
        add_menu_page(
            'Custom Login Settings',
            'DPI Login',
            'manage_options',
            'dpi-login-settings',
            [$this, 'createPage']
        );
    }

    public function enqueuePageAssets() {
        $editorStyles = '';

        if (empty(get_option('dpi_login_editor_styles'))) {
            $editorStyles = file_get_contents(plugins_url('../css/login-template.css', __FILE__));
        } else {
            $editorStyles = get_option('dpi_login_editor_styles');
        }

        wp_register_style('dpi-login-plugin-page-css', plugins_url('../css/plugin-page.css', __FILE__), '1.0.0', 'screen');
        wp_register_style('dpi-login-codemirror-css', plugins_url('../css/codemirror-soldark.css', __FILE__), '1.0.0', 'screen');
        wp_register_script('dpi-login-plugin-page-js', plugins_url('../js/plugin-page.min.js', __FILE__), ['jquery', 'wp-color-picker'], '1.0.0', true);
        wp_localize_script('dpi-login-plugin-page-js', 'dpiLoginLocal', ['styles' => $editorStyles]);
    }

    public function pageInit() {
        $this->generateSections($this->sections);
        $this->generateFields($this->fields);
    }

    public function generateSections($sections) {
        foreach($sections as $section) {
            add_settings_section(
                $section['id'],
                $section['title'],
                [$this, 'sectionsCallback'],
                'dpi-login-settings'
            );
        }
    }

    public function generateFields($fields) {
        foreach($fields as $field) {
            add_settings_field(
                $field['id'],
                $field['title'],
                [$this, 'fieldsCallback'],
                'dpi-login-settings',
                $field['section'],
                $args = [
                    'id' => $field['id'],
                    'type' => $field['input_type'],
                    'options' => array_key_exists('options', $field) ? $field['options'] : false,
                    'min' => array_key_exists('min', $field) ? $field['min'] : false,
                    'max' => array_key_exists('max', $field) ? $field['max'] : false,
                    'default' => array_key_exists('default', $field) ? $field['default'] : false
                ]
            );

            register_setting(
                $field['section'],
                $field['id'],
                [$this, 'dpiLoginSanitize']
            );
        }
    }

    public function sectionsCallback($args) {
        settings_fields($args['id']);
    }

    public function fieldsCallback($args) {
        $disable = get_option('dpi_login_advanced_ui');

        switch($args['type']) {
            case 'checkbox':
                printf(
                    '<input type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" %s />',
                    !empty( get_option( $args['id'] ) && get_option( $args['id'] ) == true ) ? 'checked' : ''
                );
                break;
            case 'codemirror':
                echo '<div class="editor-container ' . ($disable === 'on' ? '' : 'ui-disable') . '"><textarea id="' . $args['id'] . '" class="editor">...loading</textarea></div>';
                break;
            case 'color':
                printf(
                    '<input type="text" class="dpi-login-color ' . ($disable === 'on' ? 'ui-disable' : '') . '" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
                    !empty( get_option( $args['id'] ) ) ? get_option( $args['id'] ) : ''
                );
                break;
            case 'number':
                $min = is_numeric( $args['min'] ) ? 'min="' . $args['min'] . '"' : '';
                $max = is_numeric( $args['max'] ) ? 'max="' . $args['max'] . '"' : '';
                $value = is_numeric( $args['default'] ) && empty( get_option( $args['id'] ) ) ? $args['default'] : get_option( $args['id'] );
                echo ' <input class="' . ($disable === 'on' ? 'ui-disable' : '') . '" type="number" id="' . $args['id'] . '" name="' . $args['id'] . '" ' . $min . $max . ' value="' . $value . '" />';
                break;
            case 'select':
                $selected = get_option( $args['id'] );
                $select = '<select class="' . ($disable === 'on' ? 'ui-disable' : '') . '" id="' . $args['id'] . '" name="' . $args['id'] . '">';

                foreach($args['options'] as $k => $v) {
                    $select .= '<option ' . ($selected == $k ? "selected" : "") . ' value="' . $k . '">' . $v . '</option>';
                }

                $select .= '</select>';
                print $select;
                break;
            case 'image':
                $imgID = get_option($args['id'], '');
                $imgSrc = wp_get_attachment_image_src($imgID, 'medium');
                echo '
                        <div class="dpi-login-image-container ' . ($disable === 'on' ? 'ui-disable' : '') . '">
                            <img src="' . $imgSrc[0] . '" class="dpi-login-image" />
                            <button class="dpi-login-image-control" data-action="add">Add Image</button>
                            <button class="dpi-login-image-control ' . ($imgSrc[0] ? "" : "dpi-login-input-disabled") . '" data-action="remove">Remove Image</button>
                            <input type="hidden" class="dpi-login-image-input" id="' . $args['id'] . '" name="' . $args['id'] . '" value="' . $imgID . '" />
                        </div>
                    ';
                break;
            case 'hidden':
                printf(
                    '<input type="hidden" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
                    !empty(get_option($args['id'])) ? get_option($args['id']) : ''
                );
                break;
            default:
                printf(
                    '<input class="' . ($disable === 'on' ? 'ui-disable' : '') . '" type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
                    !empty( get_option( $args['id'] ) ) ? get_option( $args['id'] ) : ''
                );
                break;
        }
    }

    public function dpiLoginSanitize($dirty) {
        $clean = false;

        if (is_string($dirty)) {
            // $clean = sanitize_text_field($dirty); 
            $clean = esc_textarea($dirty);
        } else if (is_int($dirty)) {
            $clean = round(absint($dirty));
        }

        return $clean;
    }

    public function createPage() {
        wp_enqueue_style('dpi-login-plugin-page-css');
        wp_enqueue_style('dpi-login-codemirror-css');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('dpi-login-plugin-page-js');
        wp_enqueue_media();
        ?>
            <div id="dpi-login-settings-page" class="wrap">
                <?php settings_errors(); ?>
                <h1>Custom Login Page Settings</h1>
                <form class="dpi-login-settings-form" method="post" action="options.php" enctype="multipart/form-data">
                    <?php
                        do_settings_sections('dpi-login-settings');
                        submit_button();
                    ?>
                </form>
            </div>
        <?php
    }
}
