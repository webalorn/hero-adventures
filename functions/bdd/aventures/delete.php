<?php
    
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
    
    function deleteAventure($aventure, $userVerif = null)
    {
        $aventure = intval($aventure);
        $select = ' WHERE id = '.$aventure.' ';
        if ($userVerif != null)
        {
            $userVerif = intval($userVerif);
            $select .= "AND userId = ".$userVerif.' ';
        }
        $bdd = new Bdd();
		
		$reqResult = $bdd->query("SELECT id FROM aventures".$select);
		while ($adv = $reqResult->fetch()) {
			$bdd->exec('DELETE FROM page WHERE aventure = '.$adv['id']);
			$bdd->exec('DELETE FROM dossiers WHERE aventure = '.$adv['id']);
		}
		
        $bdd->exec('DELETE FROM aventures'.$select);
    }
    
?>
