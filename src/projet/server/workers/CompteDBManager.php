<?php
require_once("Connexion.php");
class CompteDBManager
{

    private $connexion;
    public function __construct(){
        $this->connexion = Connexion::getInstance();
    }

    public function ajouterCompte($username, $password){
        $retour = false;
        $query = "SELECT * FROM T_Compte WHERE nom_utilisateur = ?";
        $params = [$username];

        $resultats = $this->connexion->selectQuery($query, $params);
        if($resultats->rowCount() === 0){
            $createQuery = `INSERT INTO 'T_Compte' ('pk_compte', 'nom_utilisateur', 'mot_de_passe', 'est_admin') VALUES (NULL, ?, ?, 0)`;
            $params = [$username, $password];
            $retour = $this->connexion->executeQuery($createQuery, $params);
        }
        return $retour;
    }

    public function checkLogin($username, $password){
        $compte = null;
        
        $query = "SELECT * FROM T_Compte WHERE nom_utilisateur = ? AND mot_de_passe = ?";
        $params = [$username, $password];

        $resultat = $this->connexion->selectSingleQuery($query, $params);   
        if($resultat){
            $compte = new Compte($resultat["pk_compte"], $resultat["nom_utilisateur"], $resultat["mot_de_passe"], $resultat["est_admin"]);
        }
        return $compte;
    }
}

?>