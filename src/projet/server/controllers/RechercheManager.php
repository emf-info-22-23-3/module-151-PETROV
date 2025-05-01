<?php
include_once("./workers/RechercheDBManager.php");

/**
 * Contrôleur de gestion de la recherche
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package controllers
 */
class RechercheManager
{
    //Attributs
    private $rechercheDBManager;

    //Constructeur
    public function __construct(){
        $this->rechercheDBManager = new RechercheDBManager();
    }

    /**
     * Méthode permettant d'effectuer une recherche de boissons
     * 
     * @param string $query Le champ entré dans la recherche
     * @param bool $vinsFilter Filtre pour les vins
     * @param bool $bieresFilter Filtre pour les bières
     * @param bool $spiritueuxFilter Filtre pour les spiritueux
     * @param bool $noAlcoolFilter Filtre pour les boissons non alcoolisées
     * @param string $order Ordre de tri des résultats
     * @param bool $onlyPromotions Indique si seuls les produits en promotion doivent être affichés
     * @return mixed Résultats de la recherche
     */
    public function effectuerRecherche($query, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions)
    {
        return $this->rechercheDBManager->effectuerRecherche($query, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions);
    }
}
?>