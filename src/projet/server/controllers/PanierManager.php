<?php
require_once("./workers/PanierDBManager.php");
class PanierManager
{

    private $panierDBManager;
    public function __construct(){
        $this->panierDBManager = new PanierDBManager();
    }

    public function ajouterBoisson($pk_boisson, $quantite, $pk_panier){
        return $this->panierDBManager->ajouterBoisson($pk_boisson, $quantite, $pk_panier);
    }

    public function ajouterPanier($pk_compte){
        return $this->panierDBManager->ajouterPanier($pk_compte);
    }

    public function getPanierUnvalidated($pk_compte){
        $this->panierDBManager->getPanierUnvalidated($pk_compte);
    }
}

?>