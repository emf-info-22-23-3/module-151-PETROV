<?php 
	include_once('workers/PaysBDManager.php');
	include_once('beans/Pays.php');
        
    if (isset($_SERVER['REQUEST_METHOD']))
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$paysBD = new paysBDManager();
			echo $paysBD->getInXML();
		}
	}
?>