<?php
namespace octopus\core;
/**
 * Class Router
 * @package octopus\core
 *
 * Cette classe permet de convertir une url en un objet Request.
 * Les URLs sont au format MVC suivant:
 *  controller/action/param_1/.../param_k
 *
 * Elle permet surtout de traduire les des URLs vers le motif précédent.
 *
 * Ainsi nous pourrions avoir comme URL
 * http://forum-exemple.fr/un-article-sur-le-mvc-1
 *
 * vue par le système comme étant une URL
 * http://forum-exemple.fr/articles/view/1/un-article-sur-le-mvc
 *
 * Ce système permet de personnaliser les URLs, les rendre plus belles et
 * surtout plus lisibles.
 *
 * IMPORTANT: En réalité le terme URL désignera ici la partie sans le nom de
 * domaine et le http://
 */
class Router{
    /*
     * Mémorise toutes les routes à parser
     */
    static $routes = array();

    /**
     * Parse une url et persiste les données analysées dans un objet Request.
     * @param $url
     * @param $request
     *  Instance d'un objet Request
     */
    static function parse($url, Request $request){
        $url = urldecode( $url );

        $url = trim( $url, '/' );
        if( empty( $url ) ){
            // si l'url est vide nous prenons la première enregistrée
            $url = Router::$routes[ 0 ][ 'url' ];
        } else {
            $matched = false; // aucune route n'a été trouvée
            foreach( Router::$routes as $route ){ // parcours des routes
                /* si aucune route n'a été trouvée et que l'url match avec la
                 * route courante, l'url est traduite.
                 */
                if( !$matched
                        && preg_match(
                        $route[ 'regex_redirection' ], $url, $match)
                ){
                    $url = $route[ 'origin' ];
                    // traduction
                    foreach( $match as $k => $v ){
                        $url = str_replace(':'.$k.':', $v, $url);
                    }
                    $match = true;
                }
            }
        } // url traduite au format controller/action/param_1/.../param_k

        /*
         * Analyse de l'url afin de paramétrer request.
         */
        $params = explode( '/', $url );
        $request->setControllerName( $params[ 0 ] );
        /* s'il y a juste le controleur de renseigner, l'action par défaut est
         * par convention index.
         */
        $action = isset( $params[1] ) ? $params[ 1 ] : 'index';
        $request->setAction( $action );


        $request->setParams( array_slice( $params, 2) );
    }

}
