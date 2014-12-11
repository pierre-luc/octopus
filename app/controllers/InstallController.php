<?php
namespace octopus\app\controllers;
use octopus\core\Controller;

class InstallController extends Controller {
    public function index() {
        $this->setLayout( 'installer' );
    }
}
