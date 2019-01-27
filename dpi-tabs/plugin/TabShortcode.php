<?php namespace DpiTabs\plugin;

use DpiTabs\core\AbstractShortcode;

class TabShortcode extends AbstractShortcode {

    public function __construct() {
        add_shortcode('dpi_tab', [$this, 'callback']);
    }

    public function callback($attrs, $content) {
        $config = $this->sanitizeAttributes(
            shortcode_atts([
                'title' => '',
                'template' => '',
            ], $attrs)
        );
        return $this->component->render($config, $content);
    }

}