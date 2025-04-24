<?php
require_once("./workers/PanierDBManager.php");
require_once("./workers/CodePromoDBManager.php");
class PanierManager
{

    private $panierDBManager;
    private $codePromoDBManager;
    public function __construct(){
        $this->panierDBManager = new PanierDBManager();
        $this->codePromoDBManager = new CodePromoDBManager();
    }

    public function ajouterBoissonAuPanier($pk_boisson, $quantite, $pk_panier){
        return $this->panierDBManager->ajouterBoissonAuPanier($pk_boisson, $quantite, $pk_panier);
    }

    public function ajouterPanier($pk_compte){
        $returnValue = null;
        $panierAjoute = $this->panierDBManager->ajouterPanier($pk_compte);
        if($panierAjoute){
            $returnValue = $this->panierDBManager->getPanierByPk($panierAjoute);
        }
        return $returnValue;
    }

    public function getPanierByPk($pk_panier){
        return $this->panierDBManager->getPanierByPk($pk_panier);
    }

    public function getPaniersValidated(){
        return $this->panierDBManager->getPaniersValidated();
    }

    public function getPanierUnvalidated($pk_compte){
        return $this->panierDBManager->getPanierUnvalidated($pk_compte);
    }

    public function setPanierValidated($pk_panier){
        return $this->panierDBManager->setPanierValidated($pk_panier);
    }

    public function getPKBoissonsDuPanier($pk_panier){
        return $this->panierDBManager->getPKBoissonsDuPanier($pk_panier);
    }

    public function isBoissonInPanier($pk_boisson, $pk_panier){
        return $this->panierDBManager->isBoissonInPanier($pk_boisson, $pk_panier);
    }

    public function getQuantite($pk_boisson, $pk_panier){
        return $this->panierDBManager->getQuantite($pk_boisson, $pk_panier);
    }

    public function deleteBoissonFromPanier($pk_boisson, $pk_panier){
        return $this->panierDBManager->deleteBoissonFromPanier($pk_boisson, $pk_panier);
    }

    public function checkCodePromo($code_promo){
        return $this->codePromoDBManager->checkCodePromo($code_promo);
    }

    public function setCodePromo($code_promo, $pk_panier){
        return $this->codePromoDBManager->setCodePromo($code_promo, $pk_panier);
    }

    public function getCodePromo($pk_panier){
        return $this->codePromoDBManager->getCodePromo($pk_panier);
    }

    public function deleteCommande($pk_panier){
        $this->codePromoDBManager->deleteCodePromo($pk_panier);
        $this->panierDBManager->deleteBoissonsDuPanier($pk_panier);
        $this->panierDBManager->deletePanier($pk_panier);
    }
}

?>