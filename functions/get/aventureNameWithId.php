<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
    
    if (isset($_POST['id']))
    {
        $bdd = new Bdd();
        $reqResult = $bdd->query("SELECT nom FROM aventures WHERE id = ".$_POST['id']);
        if ($result = $reqResult->fetch())
            echo $result['nom'];
        else
            echo 'no existe';
    }
    else
        echo 'no param';
?>
