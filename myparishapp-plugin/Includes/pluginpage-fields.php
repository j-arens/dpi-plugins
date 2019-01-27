<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Input types and their optional parameters:
*
* text -> default
* number -> default, min, max
* date -> default
* color -> default
* textarea -> default
* checkbox -> checked
* radio -> on
*
*/

return [
    [   // Authkey
        'section' => 'General Settings',
        'title' => 'Authkey',
        'input_type' => 'text'
    ],
    [   // deep link
        'section' => 'General Settings',
        'title' => 'Deep Link',
        'input_type' => 'text'
    ],
    [   // component
        'section' => 'General Settings',
        'title' => 'Component',
        'input_type' => 'select',
        'options' => [
            'slider' => 'Slider',
            'carousel' => 'Carousel'
        ],
        'default' => 'slider'
    ],
    [   // max messages
        'section' => 'General Settings',
        'title' => 'Max Messages',
        'input_type' => 'number',
        'min' => 0,
        'default' => 10
    ],
    [   // primary color
        'section' => 'General Settings',
        'title' => 'Primary Color',
        'input_type' => 'color'
    ],
    [   // secondary color
        'section' => 'General Settings',
        'title' => 'Secondary Color',
        'input_type' => 'color'
    ],
    [   // accent color
        'section' => 'General Settings',
        'title' => 'Accent Color',
        'input_type' => 'color'
    ],
    [   // text color
        'section' => 'General Settings',
        'title' => 'Text Color',
        'input_type' => 'color'
    ],
    [   // link color
        'section' => 'General Settings',
        'title' => 'Link Color',
        'input_type' => 'color'
    ]
];