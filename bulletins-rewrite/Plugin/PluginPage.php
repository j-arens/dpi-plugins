<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class PluginPage {

    private $pageTitle;
    private $menuTitle;
    private $capability;
    private $pageSlug;
    private $pageSections;
    private $pageFields;

    /**
    * Class constructor, set default props
    */
    public function __construct(array $config) {
        if (!empty($config)) {
            $this->pageTitle = $config['pageTitle'];
            $this->menuTitle = $config['menuTitle'];
            $this->capability = $config['capability'];
            $this->pageSlug = 'dpi_' . strtolower(str_replace($this->menuTitle, ' ', '_'));
            $this->pageSections = include DPI_BULLETINS_DIR . '/includes/pluginpage-sections.php';
            $this->pageFields = include DPI_BULLETINS_DIR . '/includes/pluginpage-fields.php';

            add_action('admin_menu', [$this, 'addPluginPage']);
            add_action('admin_init', [$this, 'pageInit']);
            return $this;
        }

        return trigger_error('A config array must be passed to ' . __METHOD__ . ' in ' . __CLASS__ . '!', E_USER_ERROR);
    }

    /**
    * Register the page within WP
    */
    public function addPluginPage() {
        add_menu_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->pageSlug,
            [$this, 'renderPage']
        );
    }

    /**
    * Init page creation
    */
    public function pageInit() {
        $this->registerPageSections($this->pageSections);
        $this->registerPageFields($this->pageFields);
    }

    /**
    * Register page sections within WP
    */
    private function registerPageSections(array $sections) {
        foreach($sections as $section) {
            add_settings_section(
                $section['id'],
                $section['title'],
                [$this, 'pageSectionsCallback'],
                $this->pageSlug
            );
        }
    }

    /**
    * Render out a page section
    */
    public function pageSectionsCallback($section) {
        return settings_fields($section['id']);
    }

    /**
    * Register page fields within WP
    */
    public function registerPageFields(array $fields) {
        foreach($fields as $field) {
            add_settings_field(
                $field['id'],
                $field['title'],
                [$this, 'renderField'],
                $this->pageSlug,
                $field['section'],
                $args = [
                    'id' => $field['id'],
                    'type' => $field['inputType'],
                    'options' => array_key_exists('options', $field) ? $field['options'] : false,
                    'min' => array_key_exists('min', $field) ? $field['min'] : false,
                    'max' => array_key_exists('max', $field) ? $field['max'] : false,
                    'default' => array_key_exists('default', $field) ? $field['default'] : false
                ]
            );

            register_setting(
                $field['section'],
                $field['id'],
                [$this, 'sanitizeUserInput']
            );
        }
    }

    /**
    * Attempt to sanitize user input before persisting
    */
    public function sanitizeUserInput($input) {
        switch(gettype($input)) {
            case 'boolean':
                return filter_var($input, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return round(filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT));
            default:
                return sanitize_text_field($input);
        }
    }

    /**
    * Render out a field
    */
    public function renderField($field) {
        $default = $field['default'] ? $field['default'] : '';
        $value = empty(get_option($field['id'])) ? $default : get_option($field['id']);

        switch($field['type']) {
            case 'number':
                $min = is_numeric($field['min']) ? 'min="' . $field['min'] . '"' : '';
                $max = is_numeric($field['max']) ? 'max="' . $field['max'] . '"' : '';

                echo '
                    <input type="number" id="' . $field['id'] . '" name="' . $field['id'] . '" ' . $min . $max . ' value="' . $value . '" />
                ';

                break;
            default:
                echo '<input type="' . $field['type'] . '" id="' . $field['id'] . '" name="' . $field['id'] . '" value="' . $value . '" />';
                break;
        }
    }

    /**
    * Render out the plugin page
    */
    public function renderPage() {
        return include DPI_BULLETINS_DIR . '/includes/pluginpage-template.php';
    }
}