<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');

if (isset($_POST['type']) && isset($_POST['aventure']) && isset($_POST['id']) && ($_POST['type'] == 'dossier' || $_POST['type'] == 'fichier'))
{
    $_POST['aventure'] = intval($_POST['aventure']);
    $_POST['id'] = intval($_POST['id']);
    
    $table = $_POST['type'].'s';
    if ($_POST['type'] == "fichier")
        $table = 'pages';
    $bdd = new Bdd();
    
    $req = $bdd->select('aventures', "WHERE id = :id AND userId = :user", array('id' => $_POST['aventure'], 'user' => $_SESSION['id']));
    if (!($req->fetch()))
    {
        echo 'ERROR user';
        exit;
    }
    
    $req = $bdd->select($table, "WHERE id = :id AND aventure = :adv", array('id' => $_POST['id'], 'adv' => $_POST['aventure']));
    if (!($req->fetch()))
    {
        echo 'ERROR aventure';
        exit;
    }
    
    $detruire = function ($table, $id) use (&$bdd, &$detruire)
    {
        $bdd->exec("DELETE FROM ".$table." WHERE id=".$id);
        if ($table == 'dossiers')
        {
            $req = $bdd->select('dossiers', "WHERE parent = :parent", array('parent' => $id));
            while ($dir = $req->fetch())
                $detruire('dossiers', $dir['id']);
            
            $req = $bdd->select('pages', "WHERE dossierId = :parent", array('parent' => $id));
            while ($file = $req->fetch())
                $detruire('pages', $file['id']);
        }
    };
    
    $detruire($table, $_POST['id']);
    
    echo '0';
}
else
    echo 'ERROR params';
?>
