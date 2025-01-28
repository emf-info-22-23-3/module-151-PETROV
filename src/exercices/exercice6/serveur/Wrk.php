<?php 
class Wrk{
    public __construct(){}
    public function getEquipes(){
        $equipes = new array();
        array_push($equipes, new Equipe(1, 'Gotteron'));
        array_push($equipes, new Equipe(2, 'SC Bern'));
        array_push($equipes, new Equipe(3, 'Fribourg-Gottéron'));
        array_push($equipes, new Equipe(4, 'HC Davos')); 
        return $equipes;
    }
}
?>