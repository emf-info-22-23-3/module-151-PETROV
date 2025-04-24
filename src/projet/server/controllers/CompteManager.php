<?php
require_once("./workers/CompteDBManager.php");
class CompteManager
{
 
    public function __construct(){}

    public function ajouterCompte($username, $password){
        $compteDBManager = new CompteDBManager();
        return $compteDBManager->ajouterCompte($username, $password);
    }

    public function checkLogin($username, $password){
        $compteDBManager = new CompteDBManager();
        return $compteDBManager->checkLogin($username, $password);
    }

    public function getCompteByPk($pk_compte){
        $compteDBManager = new CompteDBManager();
        return $compteDBManager->getCompteByPk($pk_compte);
    }
}

?>