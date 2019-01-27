<?php

/*
Plugin Name: DPI Custom Login
Plugin URI: http://www.diocesan.com
Description: Customize the wordpress login page.
Version: 1.0.0
Author: Josh Arens
Author URI: http://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define('DPI_LOGIN_VERSION', '1.0.0');

require_once __DIR__ . '/classes/init.php';

$dpiLogin = new DPI_Login_Init();
$dpiLogin->checkForUpdates();
$dpiLogin->loadPlugin();
