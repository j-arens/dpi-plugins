<?php namespace DpiTabs\plugin;

use DpiTabs\core\AbstractShortcode;

class TabsShortcode extends AbstractShortcode {

    public function __construct(TabsComponent $TabsComponent) {
        $this->component = $TabsComponent;
        $this->shortcode = $TabsComponent->props['shortcode'];
        add_shortcode($this->shortcode, [$this, 'callback']);
    }

    public function callback($attrs, $content) {
        $config = $this->sanitizeAttributes(
            shortcode_atts([
                'animation_class' => 'dpiFadeIn',
                'hash_navigation' => true,
            ], $attrs)
        );
        return $this->component->render($config, $content);
    }

}