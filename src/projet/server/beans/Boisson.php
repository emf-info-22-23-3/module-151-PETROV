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

    public function __construct($pk_boisson = null, $nom = null, $quantite = null, $prix = null, $image = null, $quantiteDisponible = null, $estEnSolde = null, $informations = null, $ingredients = null, $producteur = null, $region = null)
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

    public function setPkboisson($pk_boisson)
    {
        $this->pk_boisson = $pk_boisson;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getQuantiteDisponible()
    {
        return $this->quantiteDisponible;
    }
    public function setQuantiteDisponible($quantiteDisponible)
    {
        $this->quantiteDisponible = $quantiteDisponible;
    }

    public function getEstEnSolde(){
        return $this->estEnSolde;
    }

    public function setEstEnSolde($estEnSolde){
        $this->estEnSolde = $estEnSolde;
    }

    public function getInformations()
    {
        return $this->informations;
    }

    public function setInformations($informations)
    {
        $this->informations = $informations;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    public function getProducteur()
    {
        return $this->producteur;
    }

    public function setProducteur($producteur)
    {
        $this->producteur = $producteur;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;
    }
}

?>