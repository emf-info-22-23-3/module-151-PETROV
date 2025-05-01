<?php
require_once("./workers/CompteDBManager.php");

/**
 * Contrôleur de gestion des comptes
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package controllers
 */
class CompteManager
{
 
    //Attributs
    private $compteDBManager;

    //Constructeur
    public function __construct(){
        $this->compteDBManager = new CompteDBManager();
    }

    /**
     * Méthode permettant l'ajout d'un nouveau compte
     * 
     * @param string $username Nom d'utilisateur du compte
     * @param string $password Mot de passe du compte
     * @return mixed compte créé ou null si l'ajout a échoué
     */
    public function ajouterCompte($username, $password){
        return $this->compteDBManager->ajouterCompte($username, $password);
    }

    /**
     * Méthode permettant la vérification des identifiants de connexion d'un compte
     * 
     * @param string $username Nom d'utilisateur du compte
     * @param string $password Mot de passe du compte
     * @return Compte|null compte trouvé ou null si les identifiants sont incorrects
     */
    public function checkLogin($username, $password){
        return $this->compteDBManager->checkLogin($username, $password);
    }

    /**
     * Méthode permettant la récupération d'un compte à partir de son identifiant
     * 
     * @param int $pk_compte Identifiant du compte
     * @return Compte|null compte trouvé ou null si le compte n'existe pas
     */
    public function getCompteByPk($pk_compte){
        return $this->compteDBManager->getCompteByPk($pk_compte);
    }
}
?>