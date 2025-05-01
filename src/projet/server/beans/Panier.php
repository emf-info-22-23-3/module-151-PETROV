<?php

/**
 * Classe représentant un panier d'achats
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package controllers
 */
class Panier
{
    //Attributs de la classe Panier
    private $pk_panier;
    private $est_valide;
    private $fk_compte;

    //Constructeur de la classe Panier
    public function __construct($pk_panier, $est_valide, $fk_compte)
    {
        $this->pk_panier = $pk_panier;
        $this->est_valide = $est_valide;
        $this->fk_compte = $fk_compte;
    }

    //Getters
    public function getPkPanier()
    {
        return $this->pk_panier;
    }

    public function getEstValide()
    {
        return $this->est_valide;
    }

    public function getFkCompte()
    {
        return $this->fk_compte;
    }
}

?>