<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures/notes.php');
	if (!isset($_POST['idAdv'])) {
		echo 'Erreur dans les donnes';
		exit;
	}
	$idAdv = intval($_POST['idAdv']);
	aventureRemoveNote($idAdv);
	echo '0';
	
	/*$bdd = new Bdd();
	$adv = $bdd->query("SELECT notes FROM aventures WHERE id = ".$idAdv);
	
	if (!$adv = $adv->fetch()) {
		echo 'aventure inexistante';
		exit;
	}
	setcookie('noteAdv'.$idAdv, 'a vote', time()+3*2*360*24*60*60, '/');
	
	$obj = json_decode($adv['notes'], true);
	$obj['note'] = round(($obj['note']*$obj['nb'] + $note) / ($obj['nb']+1) *100) / 100;
	$obj['nb'] += 1;
	$bdd->update("aventures", "WHERE id = ".$idAdv , array(
        'notes' => json_encode($obj)
    ));
	echo '0';*/
?>
