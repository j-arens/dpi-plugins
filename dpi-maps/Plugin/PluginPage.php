<?php namespace DPIMaps\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class PLuginPage {
    
    private $sections;
    private $fields;
    
    public function __construct() {
        $this->sections = include DPI_MAPS_DIR . '/Includes/pluginpage-sections.php';
        $this->fields = include DPI_MAPS_DIR . '/Includes/pluginpage-fields.php';
    }
    
    public function register() {
        add_action('admin_menu', [$this, 'addPage']);
        add_action('admin_enqueue_scripts', [$this, 'registerAssets']);
        add_action( 'admin_init', [$this, 'pageInit'] );
    }
    
    public function addPage() {
        add_menu_page(
            'DPI Maps Settings',
            'DPI Maps',
            'manage_options',
            'dpi-maps-settings',
            [$this, 'createPage']
        );
    }
    
    public function registerAssets() {
        wp_register_style(
            'dpi-maps-pluginpage-styles',
            plugins_url('Assets/styles/pluginpage.min.css', DPI_MAPS_ROOT),
            null,
            filemtime(DPI_MAPS_DIR . '/Assets/styles/pluginpage.min.css'),
            'all'
        );
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
                'dpi-maps-settings'
            );
        }
    }
    
    public function generateFields($fields) {
        foreach($fields as $field) {
            add_settings_field(
                $field['id'],
                $field['title'],
                [$this, 'fieldsCallback'],
                'dpi-maps-settings',
                $field['section'],
                $args = [
                    'id' => $field['id'],
                    'type' => $field['input_type'],
                    'options' => array_key_exists( 'options', $field ) ? $field['options'] : '',
                    'min' => array_key_exists( 'min', $field ) ? $field['min'] : false,
                    'max' => array_key_exists( 'max', $field ) ? $field['max'] : false,
                    'default' => array_key_exists( 'default', $field ) ? $field['default'] : false,
                ]
            );

            register_setting(
                $field['section'],
                $field['id'],
                [$this, 'dpiMapsSanitize']
            );
        }
    }
    
    public function sectionsCallback($args) {
        settings_fields($args['id']);
    }
    
    public function fieldsCallback($args) {
        switch ( $args['type'] ) {
            case 'radio':
            case 'checkbox':
                printf(
                '<input type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" %s />',
                !empty( get_option( $args['id'] ) && get_option( $args['id'] ) == 'on' ) ? 'checked' : ''
                );
                break;
            case 'number':
                $min = is_numeric( $args['min'] ) ? 'min="' . $args['min'] . '"' : '';
                $max = is_numeric( $args['max'] ) ? 'max="' . $args['max'] . '"' : '';
                $value = is_numeric( $args['default'] ) && empty( get_option( $args['id'] ) ) ? $args['default'] : get_option( $args['id'] );
                echo '
                <input type="number" id="' . $args['id'] . '" name="' . $args['id'] . '" ' . $min . $max . ' value="' . $value . '" />
                ';
                break;
            case 'select':
                $selected = get_option( $args['id'] );
                $select = '<select id="' . $args['id'] . '" name="' . $args['id'] . '">';

                foreach( $args['options'] as $k => $v ) {
                    $select .= '<option ' . ($selected == $k ? "selected" : "") . ' value="' . $k . '">' . $v . '</option>';
                }

                $select .= '</select>';
                break;
            case 'textarea':
                printf(
                    '<textarea id="' . $args['id'] . '" name="' . $args['id'] . '">%s</textarea>',
                    !empty(get_option($args['id'])) ? get_option($args['id']) : ''
                );
                break;
            default:
                printf(
                '<input type="' . $args['type'] . '" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />',
                !empty( get_option( $args['id'] ) ) ? get_option( $args['id'] ) : ''
                );
                break;
            }
    }
    
    public function dpiMapsSanitize($dirty) {
        return sanitize_text_field($dirty);
    }
    
    public function createPage() {
        wp_enqueue_style('dpi-maps-pluginpage-styles');
        ob_start();
        include DPI_MAPS_DIR . '/Includes/pluginpage.php';
        echo ob_get_clean();
    }
    
}