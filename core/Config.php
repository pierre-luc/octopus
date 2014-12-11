<?php
namespace octopus;
use octopus\core\JSONConvertor;
use octopus\core\Router;

/**
 * Class Conf
 * @package octopus
 *
 * Cette classe permet de configurer les connexions aux bases de données.
 *
 */
class Config {
    static $databases = null;
    private static $parameters;
    private static $appname = 'Octopus';

    public static function loadParameters() {
        self::$parameters =
            JSONConvertor::parseFile( APP . DS . 'parameters.json' );
        self::loadDatabasesConfig();
        self::loadRouteMap();
    }

    private static function loadDatabasesConfig() {
        if ( !isset( self::$parameters[ 'databases' ] ) ) { return false; }
        self::$databases = self::$parameters[ 'databases' ];
        return true;
    }

    private static function loadRouteMap() {
        if ( !isset( self::$parameters[ 'routes' ] ) ) { return false; }

        $map = self::$parameters[ 'routes' ];
        foreach( $map as $target => $url ) {
            Router::map( $target, $url );
        }
        return true;
    }

    public static function getAppName() {
        return self::$appname;
    }
}

if ( file_exists( ROOT . DS . 'config.inc.php' ) ) {
    require_once APP . DS . 'params' . DS . 'config.inc.php';
}