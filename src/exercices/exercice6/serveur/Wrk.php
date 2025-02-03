<?php 
class Wrk{

    public function getEquipes(){
        $equipes = array();
        array_push($equipes, new Equipe(1, 'Gotteron'));
        array_push($equipes, new Equipe(2, 'SC Bern'));
        array_push($equipes, new Equipe(3, 'Fribourg-Gottéron'));
        array_push($equipes, new Equipe(4, 'HC Davos')); 
        return $equipes;
    }
}
?>