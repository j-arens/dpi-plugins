<?php

require_once 'vendor/autoload.php';

/**
 * New up plugin
 * 
 */
$plugin = new DpiTabs\plugin\Plugin();

/**
 * Load in plugin services
 * 
 */
$plugin->loadServices();

/**
 * Build out plugin bindings
 * 
 */
$plugin->build();