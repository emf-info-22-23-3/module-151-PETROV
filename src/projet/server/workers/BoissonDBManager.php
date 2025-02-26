<?php
require_once("Connexion.php");
class BoissonDBManager
{

    private $connexion;
    public function __construct(){
        $this->connexion = Connexion::getInstance();
    }

    public function getBoisson($pk_boisson){
        $boisson = null;
        $query = `SELECT * FROM T_Compte WHERE pk_boisson = ?`;
        $params = [$pk_boisson];

        $resultat = $this->connexion->selectSingleQuery($query, $params);   
        if($resultat){
            $boisson = new Boisson($resultat["pk_boisson"], $resultat["nom"], $resultat["quantite"], $resultat["prix"], $resultat["image"], $resultat["quantiteDisponible"], $resultat["estEnSolde"], $resultat["informations"], $resultat["ingredients"], $resultat["producteur"], $resultat["region"]);
        }
        return $boisson;
    }

    public function setQuantite($pk_boisson, $quantite){

        $query = ` "UPDATE T_Boisson SET quantite = ? WHERE pk_boisson = ?"`;
        $params = [$quantite, $pk_boisson];

        $retour = $this->connexion->executeQuery($query, $params);
        return $retour;

    }

    public function getQuantite($pk_boisson){
        $quantite = null;
        $query = ` "SELECT quantite FROM T_Boisson WHERE pk_boisson = ?"`;
        $params = [$pk_boisson];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if($resultat){
            $quantite = $resultat["quantite"];
        }
        return $quantite;
    }
}
?>