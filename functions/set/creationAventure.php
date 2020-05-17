<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

if (isset($_POST['nom']))
{
    $bdd = new Bdd();
	$user = intval($_SESSION['id']);
    $bdd->insert("aventures", array(
        "nom" => htmlspecialchars($_POST['nom']),
        "userId" => $user
    ));
	$reqResult = $bdd->query("SELECT * FROM aventures WHERE userId = ".$user);
	$advId = 0;
	while ($adv = $reqResult->fetch())
		$advId = $adv['id'];
	$insertion = array(
        'nom' => "index",
        'aventure' => $advId,
		'dossierId' => null,
        'contenu' => '{}'
    );
	$bdd->insert('pages', $insertion);
    echo '0';
}
else
    echo 'ERROR';

?>
