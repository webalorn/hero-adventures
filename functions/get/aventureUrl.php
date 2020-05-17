<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');
    
    if (isset($_POST['id'])) {
        $bdd = new Bdd();
        if ( $adv = $bdd->query("SELECT * FROM aventures WHERE id = ".intval($_GET['id'])) -> fetch() ) {
            echo urlReecrite($adv['nom'], $adv['id']);
        }
    }
?>
