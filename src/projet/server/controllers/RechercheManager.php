<?php
include_once("./workers/RechercheDBManager.php");
class RechercheManager
{
    public function __construct()
    {

    }

    public function effectuerRecherche($query, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions)
    {
        $rechercheDBManager = new RechercheDBManager();
        return $rechercheDBManager->effectuerRecherche($query, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions);
    }

}
?>