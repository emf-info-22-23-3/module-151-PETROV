<?php

/**
 * Classe de gestion des panier dans la base de données
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package workers
 */
class PanierDBManager
{

    //Attributs
    private $connexion;

    //Constructeur
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }

    /**
     * Méthode permettant l'ajout d'une boisson au panier dans la base de données
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $quantite Quantité de la boisson à ajouter
     * @param int $pk_panier Identifiant du panier
     * @return int Nombre de lignes affectées
     */
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

    /**
     * Méthode permettant de créer un panier pour un compte dans la base de données
     * 
     * @param int $pk_compte Identifiant du compte
     * @return int Le nombre de lignes affectées
     */
    public function ajouterPanier($pk_compte)
    {
        $query = "INSERT INTO T_Panier (fk_compte, est_valide) VALUES (?, 0)";
        $params = [$pk_compte];
        return $this->connexion->executeQuery($query, $params);
    }

    /**
     * Méthode permettant de récupérer un panier à partir de son identifiant dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return Panier|null Le panier correspondant ou null si aucun panier n'est trouvé
     */
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

    /**
     * Méthode permettant de récupérer tous les paniers validés dans la base de données
     * 
     * @return array Les paniers validés
     */
    public function getPaniersValidated(){
        $paniers = [];
        $query = "SELECT * FROM T_Panier WHERE est_valide = 1";
        $resultats = $this->connexion->selectQuery($query, []);
        foreach ($resultats as $resultat) {
            $paniers[] = new Panier($resultat["pk_panier"], $resultat["est_valide"], $resultat["fk_compte"]);
        }
        return $paniers;
    }

    /**
     * Méthode permettant de récupérer le panier non validé d'un compte dans la base de données
     * 
     * @param int $pk_compte Identifiant du compte
     * @return Panier|null Le panier non validé ou null si aucun panier n'est trouvé
     */
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

    /**
     * Méthode permettant de changer l'état d'un panier de non validé à validé dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return int Le nombre de lignes affectées
     */
    public function setPanierValidated($pk_panier)
    {
        $query = "UPDATE T_Panier SET est_valide = 1 WHERE pk_panier = ?";
        $params = [$pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }


    /**
     * Méthode permettant de récupérer l'identifiant de toutes les boissons d'un panier dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return array Les identifiants des boissons du panier
     */
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

    /**
     * Méthode permettant de vérifier si une boisson est déjà dans le panier dans la base de données
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $pk_panier Identifiant du panier
     * @return bool true si la boisson est dans le panier, false sinon
     */
    public function isBoissonInPanier($pk_boisson, $pk_panier)
    {
        $query = "SELECT * FROM TR_Panier_Boisson WHERE fk_boisson_panier = ? AND fk_panier_boisson = ?";
        $params = [$pk_boisson, $pk_panier];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat ? true : false;
    }


    /**
     * Méthode permettant de récupérer la quantité d'une boisson dans un panier dans la base de données
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $pk_panier Identifiant du panier
     * @return mixed La quantité de la boisson dans le panier ou null si la boisson n'est pas dans le panier
     */
    public function getQuantite($pk_boisson, $pk_panier)
    {
        $query = "SELECT quantite_choisie FROM TR_Panier_Boisson WHERE fk_boisson_panier = ? AND fk_panier_boisson = ?";
        $params = [$pk_boisson, $pk_panier];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat ? $resultat["quantite_choisie"] : null;
    }

    /**
     * Méthode permettant de supprimer une boisson d'un panier dans la base de données
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @param int $pk_panier Identifiant du panier
     * @return int Le nombre de lignes affectées
     */
    public function deleteBoissonFromPanier($pk_boisson, $pk_panier)
    {
        $query = "DELETE FROM TR_Panier_Boisson WHERE fk_boisson_panier = ? AND fk_panier_boisson = ?";
        $params = [$pk_boisson, $pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }

    /**
     * Méthode permettant de supprimer un panier dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return int Le nombre de lignes affectées
     */
    public function deletePanier($pk_panier)
    {
        $query = "DELETE FROM T_Panier WHERE pk_panier = ?";
        $params = [$pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }

    /**
     * Méthode permettant de supprimer toutes les boissons d'un panier dans la base de données
     * 
     * @param int $pk_panier Identifiant du panier
     * @return int Le nombre de lignes affectées
     */
    public function deleteBoissonsDuPanier($pk_panier)
    {
        $query = "DELETE FROM TR_Panier_Boisson WHERE fk_panier_boisson = ?";
        $params = [$pk_panier];
        return $this->connexion->executeQuery($query, $params);
    }
}

?>