<?php 

if ( !defined( 'ABSPATH' ) ) exit;

return [
    [
        'id' => 'dpi_bulletins_id',
        'title' => 'Bulletin ID',
        'section' => 'dpi_bulletins_options',
        'inputType' => 'text'
    ],
    [
        'id' => 'dpi_bulletins_quantity',
        'title' => 'Bulletin Quanitity',
        'section' => 'dpi_bulletins_options',
        'inputType' => 'number',
        'min' => 0,
        'max' => 10
    ]
];