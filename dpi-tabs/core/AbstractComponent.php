<?php namespace DpiTabs\core;

use DpiTabs\core\ComponentInterface;

abstract class AbstractComponent implements ComponentInterface {

    /**
     * @var array|object
     */
    public $props;

    /**
     * @var LoaderInterface
     */
    protected $assetLoader;

    /**
     * Component constructor
     */
    public function __construct(LoaderInterface $AssetLoader) {
        $this->loadProps();
        $this->assetLoader = $AssetLoader;
    }

    /**
     * Setup component props
     */
    abstract protected function loadProps();

    /**
     * Include a view within the caller's closure and output buffer it
     * 
     * @param string $path
     */
    protected function buffer($path, $vars = []) {
        if (!file_exists($path)) {
            throw new \Exception('');
            return;
        }

        extract($vars);
        ob_start();
        include $path;
        return ob_get_clean();
    }

    /**
     * Component error handler
     */
    abstract public function handleError($msg);

    /**
     * Enqueue component assets
     */
    abstract public function loadAssets();

    /**
     * Output component view
     */
    abstract public function render($attrs, $content);

}