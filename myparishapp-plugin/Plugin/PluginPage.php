<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class PluginPage {

    use PreFlight;

    private $FieldsFactory;
    private $sections;
    private $fields;
    private $pageTitle;
    private $menuTitle;
    private $menuIconPath;
    private $userCapability;
    private $prefix;
    private $pageSlug;

    /**
    * Set the pageTitle prop
    * @param{string} $str
    */
    public function setPageTitle($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->pageTitle = $str;
    }

    /**
    * Set the menuTitle prop
    * @param{string} $str
    */
    public function setMenuTitle($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->menuTitle = $str;
    }

    /**
    * Set the menuIconPath prop
    * @param{string} $str
    */
    public function setMenuIconPath($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->menuIconPath = MYPARISHAPP_DIR . $str;
    }

    /**
    * Set the userCapabiity prop
    * @param{string} $str
    */
    public function setUserCapability($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->userCapability = $str;
    }

    /**
    * Set the prefix prop
    * @param{string} $str
    */
    public function setPrefix($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->prefix = $str;
    }

    /**
    * Startup
    */
    public function init() {
        if ($this->somePropsSet(['pageTitle', 'menuTitle', 'menuIconPath', 'userCapability', 'prefix'])) {
            $this->FieldsFactory = new Fields();
            $this->pageSlug = basename(MYPARISHAPP_ROOT);
            $this->sections = include MYPARISHAPP_DIR . '/Includes/pluginpage-sections.php';
            $this->fields = include MYPARISHAPP_DIR . '/Includes/pluginpage-fields.php';
            add_action('admin_menu', [$this, 'registerPage']);
            add_action('admin_init', [$this, 'registerSections']);
            add_action('admin_init', [$this, 'registerFields']);
        }
    }

    /**
    * Format strings into snoke_case
    * @param{string} $input
    * @return string
    */
    private function snakeCase($input) {
        return strtolower(str_replace(' ', '_', $input));
    }

    /**
    * Get the menu icon path and return a url or base64 image if svg
    * @param{string} $path
    * @return string
    */
    private function getMenuIcon($path) {
        // $acceptedMimeTypes = [
        //     'image/svg+xml',
        //     'image/jpeg',
        //     'image/gif',
        // ];

        $acceptedMimeTypes = [
            'svg',
            'jpeg',
            'gif'
        ];

        $file = @file_get_contents($path);

        if (!$file) return;

        // finfo and mime_content_type extensions are not enabled by default on our (dpi's) flavor of php
        // fallback to just getting the file extension and hope it's not malicious

        // $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        // $mimeType = $fileInfo->buffer($file);
        // $mimeType = mime_content_type($file);
        
        // finfo seems to have a bug where it doesn't always get the mime type of svg's correct
        // if ($mimeType === 'image/svg+xml' || $mimeType === 'text/plain' && pathinfo($path, PATHINFO_EXTENSION) === 'svg') {
        //     return 'data:image/svg+xml;base64,' . base64_encode($file);
        // }

        // if (in_array($mimeType, $acceptedMimeTypes)) {
        //     return plugins_url($file);
        // }

        $mimeType = pathinfo($path, PATHINFO_EXTENSION);

        if (in_array($mimeType, $acceptedMimeTypes)) {
            if ($mimeType === 'svg') {
                return 'data:image/svg+xml;base64,' . base64_encode($file);
            } else {
                return plugins_url($file);
            }
        }
    }

    /**
    * Register plugin page with wp
    */
    public function registerPage() {
        add_menu_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->userCapability,
            $this->pageSlug,
            [$this, 'renderPage'],
            $this->getMenuIcon($this->menuIconPath)
        );
    }

    /**
    * Register plugin page sections (tabs)
    */
    public function registerSections() {
        foreach($this->sections as $section) {
            $sectionID = $this->prefix . $this->snakeCase($section);
            
            add_settings_section(
                $sectionID,
                $section,
                [$this, 'renderSection'],
                $sectionID
            );
        }
    }

    /**
    * Callback to render out a section
    * @param{array} $section
    */ 
    public function renderSection(Array $section) {
        settings_fields($section['id']);
        echo '<table class="form-table">';
        do_settings_fields($this->pageSlug, $section['id']);
        echo '</table>';
    }

    /**
    * Register plugin page fields
    */
    public function registerFields() {
        foreach($this->fields as $field) {
            $fieldID = $this->prefix . $this->snakeCase($field['title']);
            $sectionID = $this->prefix . $this->snakeCase($field['section']);

            add_settings_field(
                $fieldID,
                $field['title'],
                [$this, 'renderField'],
                $this->pageSlug,
                $sectionID,
                $args = [
                    'id' => $fieldID,
                    'type' => $field['input_type'],
                    'on' => array_key_exists('on', $field) ? $field['on'] : '',
                    'checked' => array_key_exists('checked', $field) ? $field['checked'] : '',
                    'options' => array_key_exists('options', $field) ? $field['options'] : '',
                    'min' => array_key_exists('min', $field) ? $field['min'] : '',
                    'max' => array_key_exists('max', $field) ? $field['max'] : '',
                    'default' => array_key_exists('default', $field) ? $field['default'] : ''
                ]
            );

            register_setting(
                $sectionID,
                $fieldID,
                [$this, 'sanitizeFields']
            );
        }
    }

    /**
    * Callback to render out a field
    * @param{array} $field
    */
    public function renderField(Array $field) {
        echo $this->FieldsFactory->createField($field);
    }

    /**
    * Enqueue plugin page assets
    */
    private function loadAssets() {
        // css
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_style(
            $this->snakeCase($this->menuTitle) . '-css',
            plugins_url('/assets/css/plugin-page.min.css', MYPARISHAPP_ROOT),
            null,
            filemtime(MYPARISHAPP_DIR . '/assets/css/plugin-page.min.css'),
            'all'
        );

        // js
        wp_enqueue_script(
            $this->snakeCase($this->menuTitle) . '-js',
            plugins_url('/assets/js/plugin-page.min.js', MYPARISHAPP_ROOT),
            ['jquery', 'wp-color-picker'],
            filemtime(MYPARISHAPP_DIR . '/assets/js/plugin-page.min.js'),
            true
        );
    }

    /**
    * Sanitize fields callback
    * @param{*} $dirty
    * @return string
    */
    public function sanitizeFields($dirty) {
        switch(gettype($dirty)) {
            default:
                return sanitize_text_field($dirty);
        }
    }

    /**
    * Render out the plugin page navigation tabs
    * @param{int} $activeTab
    * @return string
    */
    public function renderNav($activeTab) {
        $tabs = '';

        foreach($this->sections as $section) {
            $sectionID = $this->prefix . $this->snakeCase($section);

            $tabs .= '
                <a href="?page=' . $this->pageSlug . '&tab=' . $sectionID . '" class="nav-tab ' . ($activeTab === $sectionID ? "nav-tab-active" : "") . '">
                    ' . $section . '
                </a>
            ';
        }

        return $tabs;
    }

    /**
    * Render out the plugin page
    */
    public function renderPage() {
        global $wp_settings_sections;
        $this->loadAssets();
        $activeTab = $this->prefix . $this->snakeCase($this->sections[0]);

        if (isset($_GET['tab'])) {
            $activeTab = $_GET['tab'];
        }
        
        ob_start();
        include MYPARISHAPP_DIR . '/Includes/template-pluginpage.php';
        echo ob_get_clean();
    }
}