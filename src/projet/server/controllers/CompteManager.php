<?php
require_once("./workers/CompteDBManager.php");
class CompteManager
{
 
    public function __construct(){

    }

    public function ajouterCompte($username, $password){
        $compteDBManager = new CompteDBManager();
        $retour = $compteDBManager->ajouterCompte($username, password_hash($password, PASSWORD_DEFAULT));
        return $retour;
    }

    public function checkLogin($username, $password){
        $compteDBManager = new CompteDBManager();
        $compte = $compteDBManager->checkLogin($username, $password);
        return $compte;
    }
}

?>