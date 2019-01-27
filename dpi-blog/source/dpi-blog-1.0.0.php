<?php
/*
Plugin Name: DPI Blog
Plugin URI: http://www.diocesan.com
Description: Display articles from the Diocesan Blog.
Version: 1.0.0
Author: Josh Arens
Author URI: http://www.diocesan.com
License: GPL2
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

define( 'DPI_BLOG_VERSION', '1.0.0' );

$dpiBlog = DPI_Blog_Init();
$dpiBlog->checkForUpdates();
$dpiBlog->loadPlugin();