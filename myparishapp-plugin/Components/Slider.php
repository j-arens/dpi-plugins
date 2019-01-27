<?php namespace MyParishApp\Components;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Slider implements Component {

    private $messages;
    private $args;

    /**
    * Constructor
    */
    public function __construct($messages, $args) {
        $this->messages = $messages;
        $this->args = $args;
    }

    /**
    * Create custom colors style blocks
    */
    private function getCustomColors() {
        $styles = [
            [
                'selector' => '#myparishapp__root',
                'declarations' => [
                    'color' => $this->args['text_color'] ?: '#393939'
                ]
            ],
            [
                'selector' => '.myparishapp__info',
                'declarations' => [
                    'background-color' => $this->args['secondary_color'] ?: '#f2f2f2',
                    'color' => $this->args['primary_color'] ?: '#000067'
                ]
            ],
            [
                'selector' => '.myparishapp__info-icons_link:hover',
                'declarations' => [
                    'color' => $this->args['accent_color'] ?: 'cornflowerblue'
                ]
            ],
            [
                'selector' => '.myparishapp__info-link:hover',
                'declarations' => [
                    'color' => $this->args['accent_color'] ?: 'cornflowerblue'
                ]
            ],
            [
                'selector' => '.myparishapp__messages-item:hover::before',
                'declarations' => [
                    'background-color' => $this->args['primary_color'] ?: '#000067'
                ]
            ],
            [
                'selector' => '.myparishapp__messages-item:hover::after',
                'declarations' => [
                    'background-color' => $this->args['primary_color'] ?: '#000067'
                ]
            ],
            [
                'selector' => '.myparishapp__messages-item_hover::before',
                'declarations' => [
                    'background-color' => $this->args['primary_color'] ?: '#000067'
                ]
            ],
            [
                'selector' => '.myparishapp__messages-item_hover::after',
                'declarations' => [
                    'background-color' => $this->args['primary_color'] ?: '#000067'
                ]
            ],
            [
                'selector' => '.myparishapp__messages-item_link',
                'declarations' => [
                    'color' => $this->args['link_color'] ?: 'inherit',
                ]
            ],
            [
                'selector' => '.myparishapp__message-item_link:hover',
                'declarations' => [
                    'color' => $this->args['primary_color'] ?: '#000067'
                ]
            ],
            [
                'selector' => '.myparishapp__control-icon',
                'declarations' => [
                    'fill' => $this->args['secondary_color'] ?: '#ccc'
                ]
            ],
            [
                'selector' => '.myparishapp__control:hover .myparishapp__control-icon',
                'declarations' => [
                    'fill' => $this->args['primary_color'] ?: '#000067'
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
    
    /**
     * Enqueue slider styles 
     */
    private function enqueueStyles() {
        wp_enqueue_style(
            'myparishapp-slider-css',
            plugins_url('/assets/css/slider.min.css', MYPARISHAPP_ROOT),
            null,
            filemtime(MYPARISHAPP_DIR . '/assets/css/slider.min.css'),
            'all'
        );

        wp_styles()->add_inline_style('myparishapp-slider-css', $this->getCustomColors());
    }
    
    /**
     *  Enqueue slider scripts 
     */
    private function enqueueScripts() {
        wp_enqueue_script(
            'myparishapp-slider-js',
            plugins_url('/assets/js/slider.min.js', MYPARISHAPP_ROOT),
            null,
            filemtime(MYPARISHAPP_DIR . '/assets/js/slider.min.js'),
            true
        );

        wp_localize_script(
            'myparishapp-slider-js',
            'myParishAppPosts',
            array_map(function($message) {
                return [
                    'ID' => $message->ID,
                    'post_content' => wp_trim_words($message->post_content, 10, '...'),
                    'post_date' => date('n/d/y g:ia', strtotime($message->post_date)),
                    'permalink' => $message->permalink
                ];
            }, $this->messages)
        );
    }

    /**
    * Enqueue slider assets
    */
    public function loadAssets() {
        $this->enqueueStyles();
        $this->enqueueScripts();
    }

    /**
    * Generate icon links
    */
    private function iconLinks() {
        $html = '';

        $links = [
            [
                'href' => $this->args['deep_link'] ? $this->args['deep_link'] : '//myparishapp.com/',
                'icon' => '/assets/icons/mpa-icon-2.svg'
            ],
            [
                'href' => 'https://itunes.apple.com/us/app/myparish-catholic-life-every/id892066479?mt=8',
                'icon' => '/assets/icons/apple-icon.svg'
            ],
            [
                'href' => 'https://play.google.com/store/apps/details?id=com.michiganlabs.myparish',
                'icon' => '/assets/icons/android-icon.svg'
            ]
        ];

        foreach($links as $link) {
            $html .= '
                <a href="' . $link['href'] . '" target="_blank" class="myparishapp__info-icons_link">
                    ' . @file_get_contents(MYPARISHAPP_DIR . $link['icon']) . '
                </a>
            ';
        }

        return $html;
    }

    /**
    * Generate slides
    */
    private function slides() {
        $html = '';
        $counter = 0;

        while($counter < 4) {
            $message = !empty($this->messages[$counter]) ? $this->messages[$counter] : false;

            $html .= '
                <li class="myparishapp__messages-item" data-id="' . ($message->ID ?: '') . '">
                    <time class="myparishapp__messages-item_time" datetime="' . ($message->post_date_gmt ?: '') . '">
                        ' . date('n/d/y g:ia', strtotime($message->post_date)) . '
                    </time>
                    <p class="myparishapp__messages-item_content">' . (wp_trim_words($message->post_content, 10, '...') ?: '') . '</p>
                    <a href="' . (get_permalink($message) ?: '') . '" class="myparishapp__messages-item_link">View Message</a>
                </li>
            ';

            $counter++;
        }

        return $html;
    }

    /**
    * Render out the slider
    */
    public function render() {
        include MYPARISHAPP_DIR . '/Includes/template-slider.php';
    }
}