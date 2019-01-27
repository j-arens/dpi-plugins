<?php namespace DPI_Blog\Components;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

use DPI_Blog\Classes\Component;

class Error implements Component {

    private $errMessage;

    /**
    * Set an error message to be rendered in the component
    */
    public function setErrMessage($str) {
        if (gettype($str) === 'string') {
            $this->errMessage = $str;
        } else {
            throw new Exception('DPI_BLOG_ERROR: setErrMessage expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Enqueue component specefic assets
    */
    public function loadAssets() {
        return false;
    }

    /**
    * Render the component
    */
    public function render() {
        return '
            <div>' . (empty($this->errMessage) ? 'Uh oh, there was an error. Please contact support.' : $this->errMessage) . '</div>
        ';
    }
}