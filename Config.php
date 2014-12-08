<?php
namespace octopus;
/**
 * Class Conf
 * @package octopus
 *
 * Cette classe permet de configurer les connexions aux bases de données.
 *
 */
class Config {
    static $databases = array(
        'default' => array(
            'host' => 'localhost',
            'database' => 'octopus',
            'login' => 'root',
            'password' => 'toor'
        )
    );
}
