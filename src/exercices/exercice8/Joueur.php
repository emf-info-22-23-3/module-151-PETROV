<?php

class Joueur {

    private $pk_joueur;
    private $nom;
    private $fk_equipe;
    private $points;
    public function __construct($pk_joueur, $nom, $fk_equipe, $points)
    {
        $this->pk_joueur = $pk_joueur;
        $this->nom = $nom;
        $this->fk_equipe = $fk_equipe;
        $this->points = $points;
    }

    public function getPkJoueur(){
        return $this->pk_joueur;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getFKEquipe(){
        return $this->fk_equipe;
    }
    public function getPoints(){
        return $this->points;
    }
}

?>