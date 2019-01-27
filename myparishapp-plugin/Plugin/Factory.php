<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Factory {

    use PreFlight;

    private $postTypeName;
    private $components;

    /**
    * Set the postTypeName prop
    * @param{string} $str
    */
    public function setPostTypeName($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->postTypeName = $str;
    }

    /**
    * Set the components prop
    * @param{array} $arr
    */
    public function setComponents(Array $arr) {
        if (!$this->compareType('array', $arr)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->components = $arr;
    }

    /**
    * Get messages from the database
    * @param{int} $max
    * @return array
    */
    private function getMessages($max = -1) {
        return get_posts([
            'post_type' => $this->postTypeName,
            'post_status' => ['publish'],
            'numberposts' => $max,
        ]);
    }

    /**
    * Instantiate a new component
    * @param{array} $args
    * @return function
    */
    public function createComponent(Array $args) {
        if (in_array($args['component'], $this->components)) {
            $messages = $this->getMessages($args['max_messages']);
            
            if (empty($messages)) {
                return $this->createError('MyParish App: Sorry, there aren\'t any messages to show you right now.');
            }
            
            $class = "MyParishApp\Components\\" . str_replace(' ', '_', ucwords($args['component']));
            $component = new $class($messages, $args);
            $component->loadAssets();
            return $component->render();
        } else {
            return $this->createError(
                $args['component'] . ' is not a component. You must use one of the following:<br />- ' . implode('<br />-', $this->components)
            );
        }
    }

    /**
    * Instantiate an error component
    * @param{string} $message
    * @return function
    */
    public function createError($message) {
        $error = new Error($message);
        $error->loadAssets();
        return $error->render();
    }
}