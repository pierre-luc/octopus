<?php
namespace octopus;

/* D'un système à l'autre les séparateurs ne sont pas les mêmes. Cette constante
 * permte d'assurer une écriture correcte des chemins d'accès aux fichiers.
 */
define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT', dirname( dirname( __FILE__ ) )  );

/* Constante permettant représentant la racine virtuelle de l'application.
 */
define( 'URL_ROOT',
(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] != 'localhost'))
    ? $_SERVER['SERVER_NAME']
    : dirname( dirname( $_SERVER[ 'SCRIPT_NAME' ] ) )
);

// les constantes suivantes sont des raccourcis
define( 'APP', ROOT . DS . 'app' );
define( 'CORE', ROOT . DS . 'core' );
define( 'VIEWS', APP . DS . 'views' );
define( 'MODELS', APP . DS . 'models' );
define( 'CONTROLLERS', APP . DS . 'controllers' );

Kernel::run();