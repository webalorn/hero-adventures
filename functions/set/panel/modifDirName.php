<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');

if (isset($_POST['nom']) && isset($_POST['aventure']) && isset($_POST['id']))
{
    $aventure = intval($_POST['aventure']);
    $id = intval($_POST['id']);
    $nom = htmlspecialchars($_POST['nom']);
    
    $bdd = new Bdd();
    
    $req = $bdd->select('aventures', "WHERE id = :id AND userId = :user", array('id' => $aventure, 'user' => $_SESSION['id']));
    if (!($req->fetch()))
    {
        echo 'ERROR user';
        exit;
    }
    
    $req = $bdd->select("dossiers", "WHERE id = :id AND aventure = :adv", array('id' => $id, 'adv' => $aventure));
    if (!($req->fetch()))
    {
        echo 'ERROR aventure';
        exit;
    }
    
    
    $bdd->update("dossiers", "WHERE id = ".$id, array( "nom" => $nom));
    
    echo '0';
}
else
    echo 'ERROR params';
?>
