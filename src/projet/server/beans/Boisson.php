<?php

class Boisson
{

    private $pk_boisson;

    private $nom;
    private $quantite;

    private $prix;
    private $image;
    private $quantiteDisponible;

    private $estEnSolde;
    private $informations;
    private $ingredients;
    private $producteur;
    private $region;

    public function __construct($pk_boisson, $nom, $quantite, $prix, $image, $quantiteDisponible, $estEnSolde, $informations, $ingredients, $producteur, $region)
    {
        $this->pk_boisson = $pk_boisson;
        $this->nom = $nom;
        $this->quantite = $quantite;
        $this->prix = $prix;
        $this->image = $image;
        $this->quantiteDisponible = $quantiteDisponible;
        $this->estEnSolde = $estEnSolde;
        $this->informations = $informations;
        $this->ingredients = $ingredients;
        $this->producteur = $producteur;
        $this->region = $region;
    }
    public function getPkboisson()
    {
        return $this->pk_boisson;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getQuantiteDisponible()
    {
        return $this->quantiteDisponible;
    }

    public function getEstEnSolde(){
        return $this->estEnSolde;
    }
    public function getInformations()
    {
        return $this->informations;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function getProducteur()
    {
        return $this->producteur;
    }

    public function getRegion()
    {
        return $this->region;
    }
}

?>