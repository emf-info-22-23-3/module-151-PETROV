<?php
class PanierDBManager
{

    private $connexion;
    public function __construct(){
        $this->connexion = Connexion::getInstance();
    }

    public function ajouterBoisson($pk_boisson, $quantite, $pk_panier){
        $query = `INSERT INTO TR_Panier_Boisson (fk_panier, quantite, fk_boisson) VALUES (?, ?, ?)`;
        $params = [$pk_panier, $quantite, $pk_boisson];
    }

    public function ajouterPanier($pk_compte){
        //return $this->panierDBManager->ajouterPanier($pk_compte);
    }

    public function getPanierUnvalidated($pk_compte){
        $panier = null;
        $query = ` "SELECT * FROM T_Panier WHERE fk_compte = ? AND estValide = 0"`;
        $params = [$pk_compte];

        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if($resultat){
            $panier = new Panier($resultat["pk_panier"], $resultat["fk_compte"], $resultat["estValide"]);
        }
        return $panier;
    }
}

?>