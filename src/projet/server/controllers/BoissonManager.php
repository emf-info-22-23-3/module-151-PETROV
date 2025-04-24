<?php
require_once("./workers/BoissonDBManager.php");
class BoissonManager
{

    private $boissonDBManager;
    public function __construct(){
        $this->boissonDBManager = new BoissonDBManager();
    }

    public function getBoisson($pk_boisson){
        return $this->boissonDBManager->getBoisson($pk_boisson);
        
    }

    public function setQuantite($pk_boisson, $quantite){
        $this->boissonDBManager->setQuantite($pk_boisson, $quantite);
    }

    public function getQuantite($pk_boisson){
        return $this->boissonDBManager->getQuantite($pk_boisson);
    }

    public function getBoissonsEnSoldes(){
        return $this->boissonDBManager->getBoissonsEnSoldes();
    }
}

?>