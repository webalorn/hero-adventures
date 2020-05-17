<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
    session_start();
    if (isset($_POST['id']))
    {
        $bdd = new Bdd();
        $reqResult = $bdd->query("SELECT * FROM aventures WHERE id = ".$_POST['id']);
        if ($adv = $reqResult->fetch())
        {
            if ($adv['userId'] == $_SESSION['id'])
            {
                $_SESSION['aventureId'] = intval($adv['id']);
                $_SESSION['aventureName'] = $adv['nom'];
            }
            else
                echo 'mauvais user';
        }
        else
            echo 'no fetch';
    }
    else
        echo 'no post id';
?>
