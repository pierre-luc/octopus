<?php
namespace octopus;
use octopus\core\utils\JSONConvertor;
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
    private static $routes;
    private static $appname = 'Octopus';

    public static function loadParameters() {
        self::$parameters =
            JSONConvertor::parseFile( APP . DS . 'parameters.json' );
        self::loadDatabasesConfig();
    }

    private static function loadDatabasesConfig() {
        if ( !isset( self::$parameters[ 'databases' ] ) ) { return false; }
        self::$databases = self::$parameters[ 'databases' ];
        return true;
    }

    public static function loadRouteMap() {
        self::$routes =
            JSONConvertor::parseFile( APP . DS . 'routes.json' );
        if ( self::$routes == null ) { return false; }

        $map = self::$routes;
        foreach( $map as $target => $url ) {
            Router::map( $target, $url );
        }
        return true;
    }

    public static function getAppName() {
        return self::$appname;
    }
}
