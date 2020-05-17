<?php

session_start();

if (!isset($_SESSION['id']))
{
    header("Location: /site/connexion.php?deconnecte");
    exit;
}

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/panel/template.php');

template_getPage($_GET);

?>
