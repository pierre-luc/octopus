<?php
namespace octopus\app\controllers;
use octopus\Config;
use octopus\core\Controller;
use octopus\core\DataBaseManager;

class InstallController extends Controller {

    public function index() {
        $this->setLayout( 'installer' );
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

        $this->redirect( 'install/databaseInstallation' );
    }

    public function databaseInstallation() {
        $this->setLayout( 'installer' );
    }

    public function databaseInstallationProcess() {
        Config::loadParameters();
        $dbname = Config::$databases[ 'default' ][ 'database' ];
        $f = fopen( APP . DS . $dbname . ".sql", "r");
        $sql = "";
        while (($data = fgets($f)) != NULL) {
            if (substr($data, 0, 2) != "--") {
                $data = str_replace(chr(10), chr(13), $data);
                $data = str_replace(chr(13)," ", $data);
                $sql = $sql.$data;
            }
        }
        fclose($f);
        $tSql = explode(";", $sql);

        unset($tSql[sizeof($tSql) - 1]);
        foreach ($tSql as $e) {
            DataBaseManager::execute($e.';');
        }
        die();
    }
}
