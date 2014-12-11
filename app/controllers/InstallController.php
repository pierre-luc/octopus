<?php
namespace octopus\app\controllers;
use octopus\app\Debug;
use octopus\Config;
use octopus\core\Controller;

class InstallController extends Controller {
    public function index() {
        $this->setLayout( 'installer' );
        $this->sendVariables( 'appname', Config::getAppName() );
    }

    public function database() {
        $data = $this->getData();

        // préparation du contenu pour le fichier parameters.json
        $r  = "{\n";
        $r .= "    \"databases\": {\n";
        $r .= "        \"default\": {\n";
        $r .= "            \"database\": \"{$data->dbname}\",\n";
        $r .= "            \"host\": \"{$data->hostname}\",\n";
        $r .= "            \"login\": \"{$data->login}\",\n";
        $r .= "            \"pass\": \"{$data->pass}\"\n";
        $r .= "        }\n";
        $r .= "    }\n";
        $r .= "}\n";

        // Création du fichier parameters.json
        $f = fopen( APP . DS . 'parameters.json', 'a' );
        fwrite( $f, $r );
        fclose( $f );
        die();
    }
}
