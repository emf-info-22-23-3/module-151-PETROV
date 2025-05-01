<?php



/**
 * Classe représentant une boisson
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package beans
 */
class Boisson
{

    //Attributs de la classe Boisson
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

    //Constructeur de la classe Boisson
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

    //Getters
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

    public function getInformations()
    {
        return $this->informations;
    }

    public function getEstEnSolde(){
        return $this->estEnSolde;
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


    //Setters
    public function setPkboisson($pk_boisson)
    {
        $this->pk_boisson = $pk_boisson;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setQuantiteDisponible($quantiteDisponible)
    {
        $this->quantiteDisponible = $quantiteDisponible;
    }

    public function setEstEnSolde($estEnSolde){
        $this->estEnSolde = $estEnSolde;
    }

    public function setInformations($informations)
    {
        $this->informations = $informations;
    }

    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    public function setProducteur($producteur)
    {
        $this->producteur = $producteur;
    } 

    public function setRegion($region)
    {
        $this->region = $region;
    }
}

?>