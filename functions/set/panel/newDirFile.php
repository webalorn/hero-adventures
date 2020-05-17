<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');

if (isset($_POST['type']) && isset($_POST['parent']) && isset($_POST['nom']) && isset($_POST['aventure']) 
   && ($_POST['type'] == 'dossier' || $_POST['type'] == 'fichier'))
{
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
    
    $insertion = array(
        'nom' => htmlspecialchars($_POST['nom']),
        'aventure' => $_POST['aventure'],
    );
    if ($_POST['type'] == 'dossier')
    {
        $insertion['parent'] = $_POST['parent'];
    }
    else
    {
        $insertion['dossierId'] = $_POST['parent'];
        $insertion['contenu'] = '{}';
    }
    
    $bdd->insert($table, $insertion);
    echo '0';
}
else
    echo 'ERROR params';
?>
