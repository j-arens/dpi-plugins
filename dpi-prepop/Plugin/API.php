<?php namespace PrePopulate\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class API extends \WP_Rest_Controller {

    protected $namespace = 'dpi';
    protected $version = 'v1';
    private $churchId = '';

    /**
    * Transform data into json to send
    * @param {*} $item;
    * @param {string} $type
    * @return json
    */
    private function prepareItemForRes($item, $type) {
        return json_encode([$type => $item]);
    }

    /**
    * Verify the wp rest api nonce
    * @param {int} $req
    * @return {boolean} true/false
    */
    private function verifyNonce($req) {
        return wp_verify_nonce($req->get_header('X-WP-Nonce'), 'wp_rest');
    }
    
    /**
    * Prepare and return appropiate response
    * @param {object} $req
    * @param {*} $item
    * @return {object} api response
    */
    private function returnResponse($req, $item = '') {
        $params = $req->get_params();
        
        if (empty($item)) {
            return new \WP_Error(400, 'Unable to retrieve the ' . $params->type . ' !');
        }
        
        $data = $this->prepareItemForRes($item, $params['type']);
        return new \WP_REST_Response($data, 200);
    }

    /**
    * Get the requested data
    * @param {object} $req
    * @return {method} api repsonse
    */
    public function getItem($req) {
        $params = $req->get_params();

        if (!$this->verifyNonce($req)) {
            return new \WP_Error(403, 'Invalid Nonce!');
        }

        if (function_exists('dpi_get_church_id')) {
            $this->churchId = dpi_get_church_id(get_current_user_id());
        }

        switch($params['type']) {
            case 'CHURCH_ID':
                return $this->returnResponse($req, $this->churchId);

            case 'CHURCH_NAME':
                $res = '';

                if (function_exists('dpi_get_church_name')) {
                    $res = dpi_get_church_name($this->churchId);
                }

                return $this->returnResponse($req, $res);

            case 'CHURCH_PHONE':
                $res = '';

                if (function_exists('dpi_get_church_phone')) {
                    $res = dpi_get_church_phone($this->churchId);
                }

                return $this->returnResponse($req, $res);

            case 'CHURCH_ADDRESS':
                $res = '';

                if (function_exists('dpi_get_church_address')) {
                    $address = dpi_get_church_address($this->churchId);
                    $res = implode(' ', get_object_vars($address));
                }

                return $this->returnResponse($req, $res);

            case 'CHURCH_STREET':
                $res = '';

                if (function_exists('dpi_get_church_address')) {
                    $address = dpi_get_church_address($this->churchId);
                    $res = $address->address;
                }

                return $this->returnResponse($req, $res);

            case 'CHURCH_CITY':
                $res = '';

                if (function_exists('dpi_get_church_address')) {
                    $address = dpi_get_church_address($this->churchId);
                    $res = $address->city;
                }

                return $this->returnResponse($req, $res);

            case 'CHURCH_STATE':
                $res = '';

                if (function_exists('dpi_get_church_address')) {
                    $address = dpi_get_church_address($this->churchId);
                    $res = $address->state;
                }

                return $this->returnResponse($req, $res);

            case 'CHURCH_ZIP':
                $res = '';

                if (function_exists('dpi_get_church_address')) {
                    $address = dpi_get_church_address($this->churchId);
                    $res = $address->zip;
                }

                return $this->returnResponse($req, $res);

            case 'BULLETIN_ID':
                $res = '';

                if (function_exists('dpi_get_bulletin_id')) {
                    $res = dpi_get_bulletin_id($this->churchId);
                }

                return $this->returnResponse($req, $res);

            case 'USER_NAME':
                $res = '';

                $user = get_userdata(get_current_user_id());
                $res = $user->display_name;

                return $this->returnResponse($req, $res);

            case 'USER_EMAIL':
                $res = '';

                $user = get_userdata(get_current_user_id());
                $res = $user->user_email;

                return $this->returnResponse($req, $res);
                
            default:
                return $this->returnResponse();
        }
    }

    /**
    * Register rest api routes
    */
    public function registerRoutes() {
        register_rest_route(
            $this->namespace . '/' . $this->version,
            '/pre-populate',
            ['methods' => \WP_REST_Server::READABLE, 'callback' => [$this, 'getItem']]
        );
    }
}