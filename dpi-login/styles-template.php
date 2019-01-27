<?php

add_action('login_enqueue_scripts', function() {
    ?>
        <style type="text/css">

            /**
            * Body
            */
            body {
                background-color: '';
                background-image: '';
                background-position: '';
                background-size: '';
            }

            /**
            * Logo / link
            */
            body.login div#login h1 a {
                background-image: url();
                height: '';
                width: '';
                background-size: '';
                background-repeat: '';
                padding: '';
                margin: '';
            }

            /**
            * Form
            */
            body.login  div#login form#loginform {
                background-color: '';
            }

            /**
            * Labels
            */
            body.login div#login form#loginform p label {
                font-size: '';
                font-color: '';
            }

            body.login div#login form#loginform p.forgetmenot { /* remember me label */
                font-size: '';
                font-color: '';
            }

            /**
            * Inputs
            */
            body.login div#login form#loginform input#user_login { /* username input */

            }

            body.login div#login form#loginform input#user_pass { /* password input */

            }

            body.login div#login form#loginform input#rememberme { /* remember me checkbox */

            }

            /**
            * Buttons
            */
            body.login div#login form#loginform p.submit input#wp-submit {
                background-color: '';
                font-size: '';
                font-color: '';
                margin: '';
                padding: '';
                width: '';
                height: '';
                border-color: '';
                box-shadow: 0 1px 0 '';
                text-shadow: 0 -1px 1px '', 1px 0 1px '', 0 1px 1px '', -1px 0 1px '';
            }

            /**
            * Links
            */
            body.login div#login p#nav a { /* lost password link */

            }

            body.login div#login p#backtoblog a { /* back to site link */

            }

        </style>
    <?php
});

add_filter('login_headerurl', function() {
    return '/';
});