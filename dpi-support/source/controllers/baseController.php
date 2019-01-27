<?php namespace DPISupport\Controllers;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class BaseController {

    public function renderHome($req, $res, $service) {
        $service->pageTitle = 'Home';
        $service->bodyClass = 'home l-home';
        return $service->render(DPISUPPORT_DIR . '/includes/partials/home.php');
    }
}