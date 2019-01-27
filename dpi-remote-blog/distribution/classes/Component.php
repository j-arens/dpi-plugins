<?php namespace DPI_Blog\Classes;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

/**
* All view components must implement this interface and define loadAssets() and render().
* This is done to normalize and ensure all components are common.
*/
interface Component {

    public function loadAssets();

    public function render();
}