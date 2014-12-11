<?php
namespace octopus\core;

/**
 * Class JSONConvertor
 * @package octopus\core
 *
 * Cette classe est outil qui permet de convertir du json au format text en
 * tableau associatif. Et réciproquement, de convertir un tableau
 * associatif en chaîne de caractères au format JSON.
 */
class JSONConvertor {
    public static function textToJSON( $text ) {
        return json_decode( $text, true );
    }

    public static function JSONToText( $json ) {
        return json_encode( $json );
    }
}
