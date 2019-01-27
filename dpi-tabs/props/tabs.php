<?php

return [
    'shortcode' => 'dpi_tabs',
    'styles' => [
        'id' => 'dpi-tabs-style',
        'url' => plugins_url('/Assets/styles/tabs-fe.min.css', DPITABS_ROOT),
        'path' => DPITABS_DIR . '/Assets/styles/tabs-fe.min.css',
    ],
    'scripts' => [
        'id' => 'dpi-tabs-js',
        'url' => plugins_url('/Assets/js/tabs.min.js', DPITABS_ROOT),
        'path' => DPITABS_DIR . '/Assets/js/tabs.min.js',
    ],
    'views' => [
        'user-error' => DPITABS_DIR . '/includes/user-error.php',
        'wrapper' => DPITABS_DIR . '/includes/wrapper.php',
        'tab' => DPITABS_DIR . '/includes/tab.php',
        'nav-item' => DPITABS_DIR . '/includes/nav-item.php',
    ],
];