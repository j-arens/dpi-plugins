<?php namespace DPI_Blog\Classes;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Component_Factory {

    private $cptName;
    private $components;

    /**
    * Set the custom post type to get posts from
    */
    public function setCptName($str) {
        if (gettype($str) === 'string') {
            $this->cptName = $str;
        } else {
            throw new \Exception('DPI_BLOG_COMPONENT_FACTORY: setCptName expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Set the list of available components
    */
    public function setComponents($arr) {
        if (gettype($arr) === 'array') {
            $this->components = $arr;
        } else {
            throw new \Exception('DPI_BLOG_COMPONENT_FACTORY: setComponents expects an array. You passed a(n)' . gettype($arr) . '.');
            return false;
        }
    }

    /**
    * Startup
    */
    public function init() {
        if (count(array_filter(get_object_vars($this))) === 2) {
            return true;
        } else {
            throw new \Exception('DPI_BLOG_COMPONENT_FACTORY: $cptName and $components must be set before running init.');
            return false;
        }
    }

    /**
    * Get blog posts from the database
    */
    private function getBlogPosts() {
        return get_posts([
            'post_type' => $this->cptName, 
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
    }

    /**
    * Instantiate a new component
    */
    public function createComponent($args) {
        if (in_array($args['component'], $this->components)) {
            $posts = $this->getBlogPosts();
            $class = "DPI_Blog\Components\\" . str_replace(' ', '_', ucwords($args['component']));
            $component = new $class($posts, $args);
            $component->loadAssets();
            return $component->render();
        } else {
            return $this->createError(
                ucfirst($args['component']) . ' is not a component. You must use one of the following:<br />- ' . implode('<br />- ', $this->components)
            );
        }
    }
    
    /**
     * Instantiate a new error component
     */
    public function createError($message) {
        $error = new DPI_Blog_Error();
        $error->setErrMessage($message);
        $error->loadAssets();
        return $error->render();
    }
}