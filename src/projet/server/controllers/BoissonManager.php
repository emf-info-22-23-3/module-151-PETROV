<?php
require_once("./workers/BoissonDBManager.php");

/**
 * Contrôleur de gestion des boissons
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package controllers
 */
class BoissonManager
{

    //Attributs
    private $boissonDBManager;

    //Constructeur
    public function __construct(){
        $this->boissonDBManager = new BoissonDBManager();
    }

    /**
     * Méthode récupérant une boisson à partir de son identifiant
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @return Boisson|null Objet Boisson ou null si la boisson n'existe pas
     */
    public function getBoisson($pk_boisson){
        return $this->boissonDBManager->getBoisson($pk_boisson);
        
    }

    /**
     * Méthode changeant la quantité disponible d'une boisson
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $quantite Nouvelle quantité de la boisson
     * @return void
     */
    public function setQuantite($pk_boisson, $quantite){
        $this->boissonDBManager->setQuantite($pk_boisson, $quantite);
    }

    /**
     * Méthode récupérant la quantité restante d'une boisson
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @return mixed Quantité restante de la boisson ou null si la boisson n'existe pas
     */
    public function getQuantite($pk_boisson){
        return $this->boissonDBManager->getQuantite($pk_boisson);
    }


    /**
     * Méthode récupérant toutes les boissons en soldes
     * 
     * @return array Liste des objets Boisson en soldes
     */
    public function getBoissonsEnSoldes(){
        return $this->boissonDBManager->getBoissonsEnSoldes();
    }
}

?>