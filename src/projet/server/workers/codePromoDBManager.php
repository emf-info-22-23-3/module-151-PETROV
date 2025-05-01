<?php
require_once("Connexion.php");

/**
 * Classe de gestion des codes de promotion dans la base de données
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package workers
 */
class CodePromoDBManager
{

    //Attributs
    private $connexion;

    //Constructeur
    public function __construct(){
        $this->connexion = Connexion::getInstance();
    }

    /**
     * Méthode permettant de vérfier si un code promo existe et n'est pas utilisé dans la base de données
     * 
     * @param string $code_promo Le code promo à vérifier
     * @return mixed true si le code promo est valide, false sinon
     */
    public function checkCodePromo($code_promo){
        $query = "SELECT * FROM T_Code_reduction WHERE valeur = ? AND fk_panier IS NULL";
        $params = [$code_promo];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat;
    }

    /**
     * Méthode permettant d'attribuer un code promo à un panier dans la base de données
     * 
     * @param string $code_promo Le code promo à vérifier
     * @param int $pk_panier Identifiant du panier
     * @return mixed true si le code promo a été attribué, false sinon
     */
    public function setCodePromo($code_promo, $pk_panier){
        $query = "UPDATE T_Code_reduction SET fk_panier = ? WHERE valeur = ?";
        $params = [$pk_panier, $code_promo];
        $resultat = $this->connexion->executeQuery($query, $params);
        return $resultat;
    }

    /**
     * Méthode permettant de récupérer le code promo d'un panier dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return mixed Le code promo du panier ou null si aucun code promo n'est trouvé
     */
    public function getCodePromo($pk_panier){
        $query = "SELECT * FROM T_Code_reduction WHERE fk_panier = ?";
        $params = [$pk_panier];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat;
    }
    
    /**
     * Méthode permettant de supprimer une commande dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return void
     */    
    public function deleteCodePromo($pk_panier){
        $query = "DELETE FROM T_Code_reduction WHERE fk_panier = ?";
        $params = [$pk_panier];
        $resultat = $this->connexion->executeQuery($query, $params);
        return $resultat;
    }
}

?>