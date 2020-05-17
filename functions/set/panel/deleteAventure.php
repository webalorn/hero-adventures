<?php
    
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures/delete.php');
    
    if (isset($_POST['id']))
    {
        deleteAventure($_POST['id'], $_SESSION['id']);
        echo 0;
    }
    else
        echo 'manque params';
?>
