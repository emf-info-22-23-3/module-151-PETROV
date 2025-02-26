<?php 
	include_once('Connexion.php');
	include_once('beans/Joueur.php');
        
	class JoueurBDManager
	{

		public function readPays()
		{
			$count = 0;
			$liste = array();
			$connection = Connexion::getInstance();
			$query = $connection->selectQuery("select * from t_joueur order by Nom", array());
			foreach($query as $data){
				$joueur = new Joueur($data['PK_Joueur'], $data['Nom'], $data['FK_equipe'], $data['Points']);
				$liste[$count++] = $joueur;
			}	
			return $liste;	
		}
		
		public function getInXML()
		{
			$listeJoueurs = $this->readPays();
			$result = '<listeJoueurs>';
			for($i=0;$i<sizeof($listeJoueurs);$i++) 
			{
				$result = $result .$listeJoueurs[$i]->toXML();
			}
			$result = $result . '</listeJoueurs>';
			return $result;
		}
	}
?>
