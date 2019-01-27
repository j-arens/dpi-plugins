<?php namespace MyParishApp\Components;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Error {

    private $errMessage;

    public function __construct($errMessage) {
        $this->errMessage = $errMessage;
    }

    public function loadAssets() {
        return;
    }

    public function render() {
        return '
            <div>' . (empty($this->errMessage) ? 'Uh oh, there was an error. Please contact support.' : $this->errMessage) . '</div>
        ';
    }
}