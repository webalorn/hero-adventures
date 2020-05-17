<?php

//include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

if (isset($_POST['id']))
{
    $bdd = new Bdd();
    $reqResult = $bdd->query("SELECT id, nom, activee FROM aventures WHERE userId = ".$_POST['id']);

    $liste = array();

    while ($adv = $reqResult->fetch()) {
        $liste[] = $adv;
    }
    echo json_encode($liste);
}
else
    echo 'ERROR: no id param POST';

?>
