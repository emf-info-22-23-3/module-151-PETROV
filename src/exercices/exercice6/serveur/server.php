<?php
require_once 'Wrk.php';
require_once 'Equipe.php';

$wrk = new Wrk();
$equipes = $wrk->getEquipes();
echo json_encode($equipes);
?>