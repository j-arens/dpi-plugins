<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Widget extends \WP_Widget {

    /**
    * Init, has to call parent
    */
    public function __construct() {
        parent::__construct('dpi_bulletins_widget', 'DPI Bulletins', ['description' => 'The DPI Bulletins Widget']);
    }

    /**
    * Sanitize user input fields
    */
    private function sanitizeUserInput(array $fields) {
        return array_map(function($field) {
            return sanitize_text_field($field);
        }, $fields);
    }

    /**
    * Output the widget template in the frontend
    */
    public function widget($args, $instance) {
        $Controller = Controller::getInstance();
        $ID = $Controller->getBulletinID();

        if ($ID) {
            $quantity = $instance['bulletins'] ?: $Controller->getBulletinQuantity();
            $bulletins = $Controller->Transport->getBulletins($ID, $quantity);
            include DPI_BULLETINS_DIR . '/includes/widget-frontend-template.php';
            return true;
        }

        echo '<p>DPI Bulletins Widget: Please add a bulletin ID in the plugin settings page.</p>';
        return false;
    }

    /**
    * Update values of widget instance
    */
    public function update($new_instance, $old_instance) {
        return array_merge($old_instance, $this->sanitizeUserInput($new_instance));
    }

    /**
    * Output widget form in the backend widget editor
    */
    public function form($instance) {
        $title = '';
        $text = '';
        $bulletins = 4;

        if (!empty($instance)) {
            extract($instance, EXTR_OVERWRITE);
        }

        return include DPI_BULLETINS_DIR . '/includes/widget-admin-template.php';
    }
}