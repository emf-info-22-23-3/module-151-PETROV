<?php 
	include_once('Connexion.php');
	include_once('beans/Equipe.php');
        
	class EquipeBDManager
	{

		public function readPays()
		{
			$count = 0;
			$liste = array();
			$connection = Connexion::getInstance();
			$query = $connection->selectQuery("select * from t_equipe order by Nom", array());
			foreach($query as $data){
				$equipe = new Equipe($data['PK_equipe'], $data['Nom']);
				$liste[$count++] = $equipe;
			}	
			return $liste;	
		}
		
		public function getInXML()
		{
			$listeEquipes = $this->readPays();
			$result = '<listeEquipes>';
			for($i=0;$i<sizeof($listeEquipes);$i++) 
			{
				$result = $result .$listeEquipes[$i]->toXML();
			}
			$result = $result . '</listeEquipes>';
			return $result;
		}
	}
?>
