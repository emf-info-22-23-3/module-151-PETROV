<?php
include_once("./workers/RechercheDBManager.php");
class RechercheManager
{
    public function __construct()
    {

    }

    public function getBoissons($query, $filtres, $ordre, $uniquementEnPromotion)
    {
        $rechercheDBManager = new RechercheDBManager();
        return $rechercheDBManager->getBoissons($query, $filtres, $ordre, $uniquementEnPromotion);

    }

}
?>