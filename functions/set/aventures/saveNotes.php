<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');
    
    $user = 0;
    if (isset($_SESSION['id']))
        $user = $_SESSION['id'];
    setInfosPartie(array("feuilleNotes" => $_POST['feuilleNotes']), $_POST['idAdv'], intval($user));
    echo '0';
    
?>
