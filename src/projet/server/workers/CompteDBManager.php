<?php
require_once("Connexion.php");

/**
 * Classe de gestion des comptes dans la base de données
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package workers
 */
class CompteDBManager
{

    //Attributs
    private $connexion;

    //Constructeur
    public function __construct(){
        $this->connexion = Connexion::getInstance();
    }

    /**
     * Méthode permettant l'ajout d'un nouveau compte dans la base de données
     * 
     * @param string $username Nom d'utilisateur du compte
     * @param string $password Mot de passe du compte
     * @return mixed compte créé ou null si l'ajout a échoué
     */
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

    /**
     * Méthode permettant la vérification des identifiants de connexion d'un compte dans la base de données
     * 
     * @param string $username Nom d'utilisateur du compte
     * @param string $password Mot de passe du compte
     * @return Compte|null compte trouvé ou null si les identifiants sont incorrects
     */
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

    /**
     * Méthode permettant la récupération d'un compte à partir de son identifiant dans la base de données
     * 
     * @param int $pk_compte Identifiant du compte
     * @return Compte|null compte trouvé ou null si le compte n'existe pas
     */
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