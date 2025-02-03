<?php
$bdd = new PDO('mysql:host=localhost;dbname=nomDB', 'root', 'root');
$query = 'SELECT titre FROM jeux_videos';
$statement = $bdd->prepare($query);
$statement->execute();
$reponse = $statement->fetchAll();



foreach ($reponse as $row) {
	// Afficher chaque titre
	echo $row['titre'] . '<br>';
}

$reponse->closeCursor();
?>