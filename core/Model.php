<?php
namespace octopus\core;
/**
 * Class Model
 * @package octopus\core
 *
 * Cette classe permet de gérer les données d'un model.
 * Elle utilise une instance de DataBaseManager afin
 * de pouvoir récupérer le contenu en base de données.
 */
class Model {
    const PRIMARY_KEY = 'id';
    private $dbm;

    public function __construct() {
        /* le nom de la table correspond au nom de la classe.
         * En effet la classe Model a pour but d'être dérivée.
         * Les classes filles auront des noms différents et
         * correspondent aux noms des tables.
         */
        $this->dbm =
            new DataBaseManager( 'default',
                strtolower( get_class( $this ) ) . 's',
                self::PRIMARY_KEY);
    }

    /**
     * Supprime une entrée de la table courante en fonction de son token.
     * @param $token
     */
    public function delete( $token ) {
        $this->dbm->delete( array(
            'token' => $token
        ) );
    }

    /**
     * Persiste les données dans la table courante.
     * @param array $data
     */
    public function create( $data ) {
        /* on souhaite créer une entrée. Donc si l'objet possède une clé
         * d'indexation il est nécessaire de ne pas la considérer.
         */
        if ( isset( $data[ 'id' ] ) ) {
            unset( $data[ 'id' ] );
        }
        $this->dbm->save( $data );
    }

    /**
     * Met à jour les données dans la table courante.
     * @param array $data
     *  l'incice id doit être nécessairement égal à l'indice
     * de l'entrée dans la table courante à mettre à jour.
     * @throws \Exception
     */
    public function update( $data ) {
        if ( !isset( $data[ 'id' ] ) ) {
            throw new \Exception( "Aucune clé primaire trouvée." );
        }
        $this->dbm->save( $data );
    }
}