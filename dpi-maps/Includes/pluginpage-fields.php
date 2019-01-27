<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

return [
    'api_key' => [
        'id' => 'dpi_maps_api_key',
        'title' => 'Google Maps API Key',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'text'
    ],
    'center_lat' => [
        'id' => 'dpi_maps_center_latitude',
        'title' => 'Map Center Latitude',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'text'
    ],
    'center_lng' => [
        'id' => 'dpi_maps_center_longitude',
        'title' => 'Map Center Longitude',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'text'
    ],
    'marker_lat' => [
        'id' => 'dpi_maps_marker_latitude',
        'title' => 'Marker Latitude',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'text'
    ],
    'marker_lng' => [
        'id' => 'dpi_maps_marker_longitude',
        'title' => 'Marker Longitude',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'text'
    ],
    'zoom' => [
        'id' => 'dpi_maps_zoom',
        'title' => 'Default Zoom Level (0 - 20)',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'number',
        'min' => 0,
        'max' => 20,
        'default' => 14
    ],
    'ui' => [
        'id' => 'dpi_maps_ui',
        'title' => 'Disable Default UI',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'checkbox'
    ],
    'scroll' => [
        'id' => 'dpi_maps_scrollwheel',
        'title' => 'Disable Scroll Wheel',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'checkbox'
    ],
    'dbl_click' => [
        'id' => 'dpi_maps_dblclick',
        'title' => 'Disable Double Click Zoom',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'checkbox'
    ],
    'styles' => [
        'id' => 'dpi_maps_styles',
        'title' => 'Custom Map Styles',
        'section' => 'dpi_maps_general_options',
        'input_type' => 'textarea'
    ]
];