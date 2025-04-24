<?php
require_once("Connexion.php");
class BoissonDBManager
{

    private $connexion;
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }

    public function getBoisson($pk_boisson)
    {
        $boisson = null;
        $query = "SELECT * FROM T_Boisson WHERE pk_boisson = ?";
        $params = [$pk_boisson];

        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if ($resultat) {
            //Blob encodé en base64
            $boisson = new Boisson($resultat["pk_boisson"], $resultat["nom"], $resultat["quantite"], $resultat["prix"], base64_encode($resultat["image"]), $resultat["quantite_disponible"], $resultat["est_en_solde"], $resultat["informations"], $resultat["ingredients"], $resultat["producteur"], $resultat["region"]);
        }
        return $boisson;
    }

    public function setQuantite($pk_boisson, $quantite)
    {

        $query = "UPDATE T_Boisson SET quantite_disponible = ? WHERE pk_boisson = ?";
        $params = [$quantite, $pk_boisson];

        $retour = $this->connexion->executeQuery($query, $params);
        return $retour;

    }

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

    public function getBoissonsEnSoldes()
    {
        $boissons = array();
        $query = "SELECT * FROM T_Boisson WHERE est_en_solde = 1";
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