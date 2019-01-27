<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class DPI_Login_Styles {

    private $styles = [
        'body' => [
            [
                'property' => 'background-color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_body_bg_color'
            ],
            [
                'property' => 'background-image:',
                'value_begin' => 'url(',
                'value_end' => ')',
                'key' => 'dpi_login_body_bg_image'
            ],
            [
                'property' => 'background-size',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_body_bg_size'
            ],
            [
                'property' => 'background-position:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_body_bg_position'
            ]
        ],
        'logo' => [
            [
                'property' => 'background-image:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_logo_bg_image'
            ],
            [
                'property' => 'width:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_logo_bg_width'
            ],
            [
                'property' => 'height:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_logo_bg_height'
            ],
            [
                'property' => 'background-size:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_logo_bg_size'
            ],
            [
                'property' => 'background-repeat:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_logo_bg_repeat'
            ]
        ],
        'form' => [
            [
                'property' => 'background-color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_form_bg_color'
            ]
        ],
        'labels' => [
            [
                'property' => 'font-size:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_form_labels_size'
            ],
            [
                'property' => 'color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_form_labels_color'
            ]
        ],
        'rememberme' => [
            [
                'property' => 'font-size:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_rememberme_size'
            ],
            [
                'property' => 'color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_rememberme_color'
            ]
        ],
        'submit' => [
            [
                'property' => 'background-color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_submit_bg_color'
            ],
            [
                'property' => 'border-color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_submit_border_color'
            ],
            [
                'property' => 'box-shadow:',
                'value_begin' => '0 1px 0',
                'value_end' => '',
                'key' => 'dpi_login_submit_box_shadow_color'
            ],
            [
                'property' => 'text-shadow:',
                'value_begin' => '0 -1px 1px',
                'value_end' => '',
                'key' => 'dpi_login_submit_text_shadow_color'
            ]
        ],
        'footer' => [
            [
                'property' => 'font-size:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_footer_links_size'
            ],
            [
                'property' => 'color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_footer_links_color'
            ]
        ],
        'footer_hover' => [
            [
                'property' => 'color:',
                'value_begin' => '',
                'value_end' => '',
                'key' => 'dpi_login_footer_links_hover_color'
            ]
        ]
    ];

    public function __construct() {
        add_filter('login_headerurl', [$this , 'logoLink']);
        add_action('login_enqueue_scripts', [$this, 'generateStylesheet']);
    }

    public function logoLink() {
        $href = '/';

        if (!empty(get_option('dpi_login_logo_link'))) {
            $href = get_option('dpi_login_logo_link');
        }

        return $href;
    }

    public function generateDeclarations($rule) {
        return array_reduce($this->styles[$rule], function($pv, $cv) {
            if (!empty(get_option($cv['key']))) {
                return $pv . "\n" . $cv['property'] . ' ' . $cv['value_begin'] . get_option($cv['key']) . $cv['value_end'] . ';';
            }
        });
    }

    public function generateStylesheet() {
        if (get_option('dpi_login_advanced_ui') === 'on' && !empty('dpi_login_editor_styles')) {
            echo '<style type="text/css">' . get_option('dpi_login_editor_styles') . '</style>';
        } else {
            echo '
                <style type="text/css">
                
                    /**
                    * Body
                    */
                    body {
                        ' . $this->generateDeclarations('body') . '
                    }

                    /**
                    * Logo / link
                    */
                    body.login div#login h1 a {
                        ' . $this->generateDeclarations('logo') . '
                    }

                    /**
                    * Form
                    */
                    body.login  div#login form#loginform {
                        ' . $this->generateDeclarations('form') . '
                    }

                    /**
                    * Labels
                    */
                    body.login div#login form#loginform p label {
                        ' . $this->generateDeclarations('labels') . '
                    }

                    body.login div#login form#loginform p.forgetmenot { /* remember me label */
                        ' . $this->generateDeclarations('labels') . '
                    }

                    /**
                    * Inputs
                    */
                    body.login div#login form#loginform input#rememberme { /* remember me checkbox */
                        ' . $this->generateDeclarations('rememberme') . '
                    }

                    /**
                    * Buttons
                    */
                    body.login div#login form#loginform p.submit input#wp-submit {
                        ' . $this->generateDeclarations('submit') . '
                    }

                    /**
                    * Links
                    */
                    body.login div#login p#nav a { /* lost password link */
                        ' . $this->generateDeclarations('footer') . '
                    }

                    body.login div#login p#backtoblog a { /* back to site link */
                        ' . $this->generateDeclarations('footer') . '
                    }

                    body.login div#login p#nav a:hover { /* lost password link */
                        ' . $this->generateDeclarations('footer_hover') . '
                    }

                    body.login div#login p#backtoblog a:hover { /* back to site link */
                        ' . $this->generateDeclarations('footer_hover') . '
                    }
                
                </style>
            ';
        }
    }
}
