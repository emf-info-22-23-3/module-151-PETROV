<?php

class Panier
{
    private $pk_panier;
    private $est_valide;
    private $fk_compte;

    public function __construct($pk_panier, $est_valide, $fk_compte)
    {
        $this->pk_panier = $pk_panier;
        $this->est_valide = $est_valide;
        $this->fk_compte = $fk_compte;
    }

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