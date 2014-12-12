<?php
namespace octopus\app\controllers;
use octopus\Config;
use octopus\core\Controller;
use octopus\core\DataBaseManager;
use octopus\core\utils\JSONConvertor;

class InstallController extends Controller {

    private function checkIfAlreadyInstalled() {
        Config::loadParameters();
        $dbname = Config::$databases[ 'default' ][ 'database' ];
        if ( file_exists( APP . DS . 'parameters.json' ) &&
             file_exists( APP . DS . $dbname . '_installed.sql' )
        ) {
            $this->redirect( '' );
        }
    }

    public function index() {
        $this->setLayout( 'installer' );
        $this->checkIfAlreadyInstalled();
        $conf = $dbname = Config::$databases[ 'default' ];
        if ( isset( $conf ) ) {
            $this->sendVariables( array(
                'hostname' => $conf[ 'host' ],
                'login'    => $conf[ 'login' ],
                'dbname'   => $conf[ 'database' ]
            ) );
        }
    }

    public function database() {
        $this->checkIfAlreadyInstalled();
        $data = $this->getData();
        if ( APP . DS . 'parameters.json' ) {
            unlink( APP . DS . 'parameters.json' );
        }
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
        $this->checkIfAlreadyInstalled();
    }

    public function databaseInstallationProcess() {
        $this->checkIfAlreadyInstalled();
        $dbname = Config::$databases[ 'default' ][ 'database' ];
        $json = array();
        $json[ 'status' ] = 'success';
        $file = APP . DS . $dbname . ".sql";
        if ( file_exists( $file ) ) {
            $f = fopen( $file, "r");
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
                $r = DataBaseManager::execute($e.';');
                if ( !$r ) {
                    $json[ 'status' ] = 'failure';
                }
            }
            if ( $json[ 'status' ] == 'success' ) {
                rename( $file, APP . DS . $dbname . '_installed.sql' );
            }
        } else {
            $json[ 'status' ] = 'failure';
        }
        header('Content-type: application/json');
        echo JSONConvertor::JSONToText( $json );
        die();
    }
}
