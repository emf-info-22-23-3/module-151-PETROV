<?php

class Equipe{

    private $pk_equipe;
    private $nom;
    public function __construct($pk_equipe, $nom){
        $this->pk_equipe = $pk_equipe;
        $this->nom = $nom;
    }

    public function getPkEquipe(){
        return $this->pk_equipe;
    }
    public function getNom(){
        return $this->nom;
    }
}

?>