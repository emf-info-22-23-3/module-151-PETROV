<?php
require_once("Connexion.php");

/**
 * Classe de gestion des boissons dans la base de données
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package workers
 */
class BoissonDBManager
{

    //Attributs
    private $connexion;

    //Constructeur
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }


    /**
     * Méthode récupérant une boisson dans la base de données à partir de son identifiant
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @return Boisson|null Objet Boisson ou null si la boisson n'existe pas
     */
    public function getBoisson($pk_boisson)
    {
        $boisson = null;
        $query = "SELECT * FROM T_Boisson WHERE pk_boisson = ?";
        $params = [$pk_boisson];

        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if ($resultat) {
            //Image encodée en base64
            $boisson = new Boisson($resultat["pk_boisson"], $resultat["nom"], $resultat["quantite"], $resultat["prix"], base64_encode($resultat["image"]), $resultat["quantite_disponible"], $resultat["est_en_solde"], $resultat["informations"], $resultat["ingredients"], $resultat["producteur"], $resultat["region"]);
        }
        return $boisson;
    }

    /**
     * Méthode changeant la quantité disponible d'une boisson dans la base de données
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $quantite Nouvelle quantité de la boisson
     * @return mixed true si la mise à jour a réussi, false sinon
     */
    public function setQuantite($pk_boisson, $quantite)
    {

        $query = "UPDATE T_Boisson SET quantite_disponible = ? WHERE pk_boisson = ?";
        $params = [$quantite, $pk_boisson];

        $retour = $this->connexion->executeQuery($query, $params);
        return $retour;

    }

    /**
     * Méthode récupérant la quantité restante d'une boisson dans la base de données
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @return mixed Quantité restante de la boisson ou null si la boisson n'existe pas
     */
    public function getQuantite($pk_boisson)
    {
        $quantite = null;
        $query = "SELECT quantite_disponible FROM T_Boisson WHERE pk_boisson = ?";
        $params = [$pk_boisson];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        
        if ($resultat) {
            $quantite = $resultat["quantite_disponible"];
        }
        return $quantite;
    }

    /**
     * Méthode récupérant toutes les boissons en soldes dans la base de données
     * 
     * @return array Liste des objets Boisson en soldes
     */
    public function getBoissonsEnSoldes()
    {
        $boissons = array();
        $query = "SELECT * FROM T_Boisson WHERE est_en_solde = 1 AND quantite_disponible > 0";
        $params = [];
        $resultats = $this->connexion->selectQuery($query, $params);
        foreach ($resultats as $resultat) {
            //Image encodée en base64
            $boisson = new Boisson($resultat["pk_boisson"], $resultat["nom"], $resultat["quantite"], $resultat["prix"], base64_encode($resultat["image"]), $resultat["quantite_disponible"], $resultat["est_en_solde"], $resultat["informations"], $resultat["ingredients"], $resultat["producteur"], $resultat["region"]);
            array_push($boissons, $boisson);
        }
        return $boissons;
    }
}
?>