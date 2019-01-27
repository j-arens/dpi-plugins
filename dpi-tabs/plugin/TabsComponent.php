<?php namespace DpiTabs\plugin;

use DpiTabs\core\AbstractComponent;
use DpiTabs\plugin\Parser;

class TabsComponent extends AbstractComponent {

    protected static $instance = 0;

    protected function loadProps() {
        $props = include DPITABS_DIR . '/props/tabs.php';
        $this->props = $props;
    }

    public function handleError($msg) {
        return $this->buffer(
            $this->props['views']['user-error']
        );
    }

    public function loadAssets() {
        $this->assetLoader->enqueueStyle(
            $this->props['styles']
        );
        $this->assetLoader->enqueueScript(
            $this->props['scripts']
        );
    }

    protected function kebabCase($string) {
        return strtolower(str_replace(' ', '-', $string));
    }

    protected function getTabs($content) {
        $parser = new Parser;
        $tabs = $parser->getMatches('dpi_tab', $content);

        if (empty($tabs)) {
            return [];
        }

        return array_map(function($key) use($tabs, $parser) {
            $attributes = $tabs[$key]['attributes'];
            $titleAttr = $parser->pluckAttribute('title', $attributes);
            $templateAttr = $parser->pluckAttribute('template', $attributes);
            return [
                'title' => key_exists('title', $titleAttr) ? $titleAttr['title'] : 'Tab ' . ++$key,
                'template' => key_exists('template', $templateAttr) ? $templateAttr['template'] : false,
                'content' => $tabs[$key]['content'],
            ];
        }, array_keys($tabs));
    }

    protected function createTabComponent($path, $tabs) {
        if (!file_exists($path)) {
            throw new \Exception('createTabComponent: Path does not exist!');
        }

        for ($i = 0; $i < count($tabs); $i++) {
            $tab = $tabs[$i];
            include $path;
        }
    }

    public function render($attrs, $content) {
        self::$instance++;
        $views = $this->props['views'];
        $tabs = $this->getTabs($content);

        if (empty($tabs)) {
            return $this->handleError('No tabs');
        }

        $vars = [
            'tabs' => $tabs,
            'views' => $views,
            'config' => $attrs,
        ];

        $this->loadAssets();
        return $this->buffer($views['wrapper'], $vars);
    }

}