<?php

class Compte
{

    private $pk_compte;
    private $nom_utilisateur;
    private $mot_de_passe;
    private $est_admin;

    public function __construct($pk_compte, $nom_utilisateur, $mot_de_passe, $est_admin)
    {
        $this->pk_compte = $pk_compte;
        $this->nom_utilisateur = $nom_utilisateur;
        $this->mot_de_passe = $mot_de_passe;
        $this->est_admin = $est_admin;

    }

    public function getPkCompte()
    {
        return $this->pk_compte;
    }

    public function getNomUtilisateur()
    {
        return $this->nom_utilisateur;
    }

    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    public function getEstAdmin()
    {
        return $this->est_admin;
    }
}

?>