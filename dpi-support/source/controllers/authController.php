<?php namespace DPISupport\Controllers;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class AuthController {

    /**
    * Render out the login view
    */
    public function renderLogin($req, $res, $service) {

        if (is_user_logged_in()) {
            return $res->redirect(esc_url(preg_replace('/(login\/?)$/', '', $req->uri())))->send();
        }

        update_option('dpi_docs_login_token_timestamp', time());
        $service->pageTitle = 'Log In';
        $service->bodyClass = 'login l-login-page';
        $service->headerType = 'c-site-header__tall';
        $service->redirectUrl = $req->uri();
        $service->standardLoginPath = wp_login_url();
        $service->nonce = wp_create_nonce('LoginToken' . get_option('dpi_docs_login_token_timestamp'));
        $service->render(DPISUPPORT_DIR . '/includes/layouts/login-page.php');
        exit();
    }

    /**
    * Handle ajax login requests
    */
    public function loginUser($req, $res) {
        $params = json_decode($req->body());

        if (!wp_verify_nonce($params->nonce, 'LoginToken' . get_option('dpi_docs_login_token_timestamp'))) {
            $res->code(403);
            return $res->json([
                'returnMessage' => 'Invalid security token. Please refresh the page and try again.'
            ]);
        }

        $login = wp_signon([
            'user_login' => $params->username,
            'user_password' => $params->password
        ]);

        if (is_wp_error($login)) {
            $res->code(401);
            return $res->json([
                'returnMessage' => 'Your username and/or password is incorrect. Please try again.'
            ]);
        }

        return $res->code(200)->send();
    }
}