<?php
require_once("./workers/PanierDBManager.php");
require_once("./workers/CodePromoDBManager.php");

/**
 * Contrôleur de gestion des paniers
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package controllers
 */
class PanierManager
{

    //Attributs
    private $panierDBManager;
    private $codePromoDBManager;

    //Constructeur
    public function __construct(){
        $this->panierDBManager = new PanierDBManager();
        $this->codePromoDBManager = new CodePromoDBManager();
    }


    /**
     * Méthode permettant l'ajout d'une boisson au panier
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $quantite Quantité de la boisson à ajouter
     * @param int $pk_panier Identifiant du panier
     * @return mixed true si l'ajout a réussi, false sinon
     */
    public function ajouterBoissonAuPanier($pk_boisson, $quantite, $pk_panier){
        return $this->panierDBManager->ajouterBoissonAuPanier($pk_boisson, $quantite, $pk_panier);
    }

    /**
     * Méthode permettant de créer un panier pour un compte
     * 
     * @param int $pk_compte Identifiant du compte
     * @return Panier|null Le panier créé ou null si l'ajout a échoué
     */
    public function ajouterPanier($pk_compte){
        $returnValue = null;
        $panierAjoute = $this->panierDBManager->ajouterPanier($pk_compte);
        if($panierAjoute){
            $returnValue = $this->panierDBManager->getPanierByPk($panierAjoute);
        }
        return $returnValue;
    }

    /**
     * Méthode permettant de récupérer le panier en fonction de son identifiant
     * 
     * @param int $pk_panier Identifiant du panier
     * @return Panier|null Le panier correspondant ou null si aucun panier n'est trouvé
     */
    public function getPanierByPk($pk_panier){
        return $this->panierDBManager->getPanierByPk($pk_panier);
    }

    /**
     * Méthode permettant de récupérer tous les paniers validés
     * 
     * @return array les paniers validés
     */
    public function getPaniersValidated(){
        return $this->panierDBManager->getPaniersValidated();
    }

    /**
     * Méthode permettant de récupérer le panier non validé d'un compte
     * 
     * @param int $pk_compte Identifiant du compte
     * @return Panier|null le panier non validé ou null si aucun panier n'est trouvé
     */
    public function getPanierUnvalidated($pk_compte){
        return $this->panierDBManager->getPanierUnvalidated($pk_compte);
    }

    /**
     * Méthode permettant de changer l'état d'un panier de non validé à validé
     * 
     * @param int $pk_panier Identifiant du panier
     * @return mixed true si la mise à jour a réussi, false sinon
     */
    public function setPanierValidated($pk_panier){
        return $this->panierDBManager->setPanierValidated($pk_panier);
    }

    /**
     * Méthode permettant de récupérer l'identifiant de toutes les boissons d'un panier
     * 
     * @param int $pk_panier Identifiant du panier
     * @return array Les identifiants des boissons du panier
     */
    public function getPKBoissonsDuPanier($pk_panier){
        return $this->panierDBManager->getPKBoissonsDuPanier($pk_panier);
    }

    /**
     * Méthode permettant de vérifier si une boisson est déjà dans le panier
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $pk_panier Identifiant du panier
     * @return bool true si la boisson est dans le panier, false sinon
     */
    public function isBoissonInPanier($pk_boisson, $pk_panier){
        return $this->panierDBManager->isBoissonInPanier($pk_boisson, $pk_panier);
    }

    /**
     * Méthode permettant de récupérer la quantité d'une boisson dans le panier
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $pk_panier Identifiant du panier
     * @return mixed la quantité de la boisson dans le panier ou null si la boisson n'est pas dans le panier
     */
    public function getQuantite($pk_boisson, $pk_panier){
        return $this->panierDBManager->getQuantite($pk_boisson, $pk_panier);
    }

    /**
     * Méthode permettant de supprimer une boisson du panier
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $pk_panier Identifiant du panier
     * @return mixed true si la mise à jour a réussi, false sinon
     */
    public function deleteBoissonFromPanier($pk_boisson, $pk_panier){
        return $this->panierDBManager->deleteBoissonFromPanier($pk_boisson, $pk_panier);
    }

    /**
     * Méthode permettant de vérfier si un code promo est valide
     * 
     * @param string $code_promo Le code promo à vérifier
     * @return mixed true si le code promo est valide, false sinon
     */
    public function checkCodePromo($code_promo){
        return $this->codePromoDBManager->checkCodePromo($code_promo);
    }

    /**
     * Méthode permettant d'attribuer un code promo à un panier
     * 
     * @param string $code_promo Le code promo à vérifier
     * @param int $pk_panier Identifiant du panier
     * @return mixed true si le code promo a été attribué, false sinon
     */
    public function setCodePromo($code_promo, $pk_panier){
        return $this->codePromoDBManager->setCodePromo($code_promo, $pk_panier);
    }

    /**
     * Méthode permettant de récupérer le code promo d'un panier
     * 
     * @param int $pk_panier Identifiant du panier
     * @return mixed Le code promo du panier ou null si aucun code promo n'est trouvé
     */
    public function getCodePromo($pk_panier){
        return $this->codePromoDBManager->getCodePromo($pk_panier);
    }


    /**
     * Méthode permettant de supprimer une commande
     * 
     * @param int $pk_panier Identifiant du panier
     * @return void
     */
    public function deleteCommande($pk_panier){
        $this->codePromoDBManager->deleteCodePromo($pk_panier);
        $this->panierDBManager->deleteBoissonsDuPanier($pk_panier);
        $this->panierDBManager->deletePanier($pk_panier);
    }
}
?>