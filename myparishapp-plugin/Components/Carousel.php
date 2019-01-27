<?php namespace MyParishApp\Components;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Carousel implements Component {

    private $messages;
    private $args;

    public function __construct($messages, $args) {
        $this->messages = $messages;
        $this->args = $args;
    }

    private function getCustomColors() {
        $styles = [
            [
                'selector' => '.myparish-home-feed',
                'declarations' => [
                    'background' => ''
                ]
            ],
            [
                'selector' => '.myparish-home-feed-app a',
                'declarations' => [
                    'color' => ''
                ]
            ],
            [
                'selector' => '#slider ul li a',
                'declarations' => [
                    'color' => ''
                ]
            ],
            [
                'selector' => '.myparish_icons_myparish',
                'declarations' => [
                    'fill' => ''
                ]
            ],
            [
                'selector' => '.myparish_icons_apple',
                'declarations' => [
                    'fill' => ''
                ]
            ],
            [
                'selector' => '.myparish_icons_android',
                'declarations' => [
                    'fill' => ''
                ]
            ],
            [
                'selector' => '.myparish_arrow_prev',
                'declarations' => [
                    'fill' => ''
                ]
            ],
            [
                'selector' => '.myparish_arrow_next',
                'declarations' => [
                    'fill' => ''
                ]
            ],
            [
                'selector' => '.my_parish_control_next',
                'declarations' => [
                    'background' => ''
                ]
            ],
            [
                'selector' => '.my_parish_control_prev',
                'declarations' => [
                    'background' => ''
                ]
            ],
            [
                'selector' => '.my_parish_control_next:before',
                'declarations' => [
                    'color' => ''
                ]
            ],
            [
                'selector' => '.my_parish_control_prev:before',
                'declarations' => [
                    'color' => ''
                ]
            ],
            [
                'selector' => '#slider ul li',
                'declarations' => [
                    'color' => ''
                ]
            ],
            [
                'selector' => '#slider .dpi_mpa_message_date',
                'declarations' => [
                    'color' => ''
                ]
            ]
        ];

        return array_reduce($styles, function($pv, $cv) {
            $block = $cv['selector'] . '{';

            foreach($cv['declarations'] as $property => $style) {
                $block .= $property . ': ' . $style . ';';
            }

            return $pv . $block . '}';
        });
    }

    public function loadAssets() {
        // css
        wp_enqueue_style(
            'myparishapp-carousel-css',
            plugins_url('/assets/css/carousel.min.css', MYPARISHAPP_ROOT),
            null,
            filemtime(MYPARISHAPP_DIR . '/assets/css/carousel.min.css'),
            'all'
        );

        // js
        wp_enqueue_script(
            'myparishapp-carousel-js',
            plugins_url('/assets/js/carousel.min.js', MYPARISHAPP_ROOT),
            null,
            filemtime(MYPARISHAPP_DIR . '/assets/js/carousel.min.js'),
            true
        );

        wp_styles()->add_inline_style('myparishapp-carousel-css', $this->getCustomColors());
    }

    public function render() {
        ob_start();
        include MYPARISHAPP_DIR . '/Includes/template-carousel.php';
        return ob_get_clean();
    }
}