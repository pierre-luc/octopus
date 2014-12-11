<?php
namespace octopus;
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

    public static function routemap() {

    }
}

if ( file_exists( ROOT . DS . 'config.inc.php' ) ) {
    require_once APP . DS . 'params' . DS . 'config.inc.php';
}