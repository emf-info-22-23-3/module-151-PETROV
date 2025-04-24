<?php
class PanierDBManager
{

    private $connexion;
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }

    public function ajouterBoissonAuPanier($pk_boisson, $quantite, $pk_panier)
    {
        // Vérifier si une ligne existe déjà avec cette combinaison
        $queryCheck = "SELECT quantite_choisie FROM TR_Panier_Boisson WHERE fk_panier_boisson = ? AND fk_boisson_panier = ?";
        $paramsCheck = [$pk_panier, $pk_boisson];
        $result = $this->connexion->selectSingleQuery($queryCheck, $paramsCheck);
    
        if ($result) {
            // Elle existe : on additionne les quantités
            $quantiteExistante = $result["quantite_choisie"];
            $nouvelleQuantite = $quantiteExistante + $quantite;
    
            $queryUpdate = "UPDATE TR_Panier_Boisson SET quantite_choisie = ? WHERE fk_panier_boisson = ? AND fk_boisson_panier = ?";
            $paramsUpdate = [$nouvelleQuantite, $pk_panier, $pk_boisson];
            return $this->connexion->executeQuery($queryUpdate, $paramsUpdate);
        } else {
            // Elle n'existe pas : on insère
            $queryInsert = "INSERT INTO TR_Panier_Boisson (fk_panier_boisson, quantite_choisie, fk_boisson_panier) VALUES (?, ?, ?)";
            $paramsInsert = [$pk_panier, $quantite, $pk_boisson];
            return $this->connexion->executeQuery($queryInsert, $paramsInsert);
        }
    }

    public function ajouterPanier($pk_compte)
    {
        $query = "INSERT INTO T_Panier (fk_compte, est_valide) VALUES (?, 0)";
        $params = [$pk_compte];
        return $this->connexion->executeQuery($query, $params);
    }

    public function getPanierByPk($pk_panier)
    {
        $panier = null;
        $query = "SELECT * FROM T_Panier WHERE pk_panier = ?";
        $params = [$pk_panier];

        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if ($resultat) {
            $panier = new Panier($resultat["pk_panier"], $resultat["est_valide"], $resultat["fk_compte"]);
        }
        return $panier;
    }

    public function getPaniersValidated(){
        $paniers = [];
        $query = "SELECT * FROM T_Panier WHERE est_valide = 1";
        $resultats = $this->connexion->selectQuery($query, []);
        foreach ($resultats as $resultat) {
            $paniers[] = new Panier($resultat["pk_panier"], $resultat["est_valide"], $resultat["fk_compte"]);
        }
        return $paniers;
    }

    public function getPanierUnvalidated($pk_compte)
    {
        $panier = null;
        $query = "SELECT * FROM T_Panier WHERE fk_compte = ? AND est_valide = 0";
        $params = [$pk_compte];

        $resultat = $this->connexion->selectSingleQuery($query, $params);
        if ($resultat) {
            $panier = new Panier($resultat["pk_panier"], $resultat["est_valide"], $resultat["fk_compte"]);
        }
        return $panier;
    }

    public function setPanierValidated($pk_panier)
    {
        $query = "UPDATE T_Panier SET est_valide = 1 WHERE pk_panier = ?";
        $params = [$pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }

    public function getPKBoissonsDuPanier($pk_panier)
    {
        $boissonsInfos = [];
        $query = "SELECT fk_boisson_panier, quantite_choisie FROM TR_Panier_Boisson WHERE fk_panier_boisson = ?";
        $params = [$pk_panier];
        $resultats = $this->connexion->selectQuery($query, $params);

        foreach ($resultats as $resultat) {
            $pk_boisson = $resultat["fk_boisson_panier"];
            $quantite_choisie = $resultat["quantite_choisie"];
            if (isset($boissonsInfos[$pk_boisson])) {
                $boissonsInfos[$pk_boisson] += $quantite_choisie;
            } else {
                $boissonsInfos[$pk_boisson] = $quantite_choisie;
            }
        }

        return $boissonsInfos;
    }

    public function isBoissonInPanier($pk_boisson, $pk_panier)
    {
        $query = "SELECT * FROM TR_Panier_Boisson WHERE fk_boisson_panier = ? AND fk_panier_boisson = ?";
        $params = [$pk_boisson, $pk_panier];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat ? true : false;
    }

    public function getQuantite($pk_boisson, $pk_panier)
    {
        $query = "SELECT quantite_choisie FROM TR_Panier_Boisson WHERE fk_boisson_panier = ? AND fk_panier_boisson = ?";
        $params = [$pk_boisson, $pk_panier];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat ? $resultat["quantite_choisie"] : null;
    }

    public function deleteBoissonFromPanier($pk_boisson, $pk_panier)
    {
        $query = "DELETE FROM TR_Panier_Boisson WHERE fk_boisson_panier = ? AND fk_panier_boisson = ?";
        $params = [$pk_boisson, $pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }

    public function deletePanier($pk_panier)
    {
        $query = "DELETE FROM T_Panier WHERE pk_panier = ?";
        $params = [$pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }

    public function deleteBoissonsDuPanier($pk_panier)
    {
        $query = "DELETE FROM TR_Panier_Boisson WHERE fk_panier_boisson = ?";
        $params = [$pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }
}

?>