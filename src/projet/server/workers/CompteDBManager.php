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

        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if(!$resultat){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $createQuery = "INSERT INTO T_Compte (nom_utilisateur, mot_de_passe, est_admin) VALUES (?, ?, 0)";
            $params = [$username, $hashedPassword];
            $retour = $this->connexion->executeQuery($createQuery, $params);
        }
        return $retour;
    }

    public function checkLogin($username, $password){
        $compte = null;
        $query = "SELECT * FROM T_Compte WHERE nom_utilisateur = ?";
        $params = [$username];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if($resultat){
            if(password_verify($password, $resultat["mot_de_passe"])){
                $compte = new Compte($resultat["pk_compte"], $resultat["nom_utilisateur"], $resultat["mot_de_passe"], $resultat["est_admin"]);
            }
        }
        return $compte;
    }

    public function getCompteByPk($pk_compte){
        $compte = null;
        $query = "SELECT * FROM T_Compte WHERE pk_compte = ?";
        $params = [$pk_compte];
        $resultat = $this->connexion->selectSingleQuery($query, $params);   
        if($resultat){
            $compte = new Compte($resultat["pk_compte"], $resultat["nom_utilisateur"], $resultat["mot_de_passe"], $resultat["est_admin"]);
        }
        return $compte;
    }
}

?>