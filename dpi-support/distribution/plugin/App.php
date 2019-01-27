<?php namespace DPISupport\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

use DPISupport\Controllers\BaseController;
use DPISupport\Controllers\AuthController;

class App {

    private $entrypoint;
    private $Router;
    private $BaseController;
    private $AuthController;

    /**
    * Load in classes
    */
    public function __construct() {
        $this->Router = new \Klein\Klein();
        $this->BaseController = new BaseController();
        $this->AuthController = new AuthController();
    }

    /**
    *
    */
    public function setEntrypoint($str) {
        if (gettype($str) === 'string') {
            $this->entrypoint = $str;
        } else {
            trigger_error('Invalid data type. ' . __METHOD__ . ' expects a string.', E_USER_ERROR);
        }
    }

    /**
    * Set hooks
    */
    public function init() {
        if (count(array_filter(get_object_vars($this))) === 4) {
            add_action('parse_request', [$this, 'parseRequest']);
        } else {
            trigger_error('All properties in ' . get_class($this) . ' must be set before calling ' . __METHOD__ . '.', E_USER_ERROR);
        }
    }

    /**
    * Parse url req's and determine whether to run our router or pass on to wp
    */
    public function parseRequest($query) {
        if (preg_match('(' . $this->entrypoint . ')', $query->request)) {
            $this->runRouter();
            exit();
        }

        return $query;
    }

    /**
    * Load up app routes
    */
    public function runRouter() {
        $Router = $this->Router;

        $Router->with('/' . $this->entrypoint, function() use($Router) {

            $Router->respond(function($req, $res, $service) {
                $service->layout(DPISUPPORT_DIR . '/includes/layouts/base.php');
            });

            $this->loadLoginRoutes($Router);

            if (!is_user_logged_in()) {
                $Router->respond('GET', '!@(login\/?)$', function($req, $res) {
                    $res->redirect(esc_url(home_url('/') . $this->entrypoint . '/login'));
                });
            } else {
                $this->loadBaseRoutes($Router);
            }
        });

        $Router->onHttpError(function($code, $router) {
            $router->response()->redirect(esc_url(home_url('/') . $code));
        });

        $Router->dispatch();
    }

    /**
    * Login routes
    */
    public function loadLoginRoutes($Router) {
        $Router->respond('GET', '@/(login\/?)$', [$this->AuthController, 'renderLogin']);
        $Router->respond('POST', '@(login\/?)$', [$this->AuthController, 'loginUser']);
    }

    /**
    * Base routes
    */
    public function LoadBaseRoutes($Router) {
        $Router->respond('GET', '', [$this->BaseController, 'renderHome']);
        $Router->respond('GET', '/', [$this->BaseController, 'renderHome']);
    }
}