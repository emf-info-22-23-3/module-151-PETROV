<?php
require_once("Connexion.php");
class CodePromoDBManager
{

    private $connexion;
    public function __construct(){
        $this->connexion = Connexion::getInstance();
    }

    public function checkCodePromo($code_promo){
        $query = "SELECT * FROM T_Code_reduction WHERE valeur = ? AND fk_panier IS NULL";
        $params = [$code_promo];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat;
    }

    public function setCodePromo($code_promo, $pk_panier){
        $query = "UPDATE T_Code_reduction SET fk_panier = ? WHERE valeur = ?";
        $params = [$pk_panier, $code_promo];
        $resultat = $this->connexion->executeQuery($query, $params);
        return $resultat;
    }

    public function getCodePromo($pk_panier){
        $query = "SELECT * FROM T_Code_reduction WHERE fk_panier = ?";
        $params = [$pk_panier];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat;
    }

    public function deleteCodePromo($pk_panier){
        $query = "DELETE FROM T_Code_reduction WHERE fk_panier = ?";
        $params = [$pk_panier];
        $resultat = $this->connexion->executeQuery($query, $params);
        return $resultat;
    }
}

?>