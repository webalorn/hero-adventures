<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/aventures/afficherPage.php');

//ereurs html;
//securiser html

function erreurHtml($contenu) {
	echo '<div class="redAlert">';
	echo $contenu;
	echo '</div>';
	exit;
}

if (!isset($_POST['id']) && isset($_GET['id']))
	$_POST['id'] = $_GET['id'];
if (!isset($_POST['aventure']) && isset($_GET['aventure']))
	$_POST['aventure'] = $_GET['aventure'];
if (!isset($_POST['id']) || !isset($_POST['aventure']))
	erreurHtml("Mauvais paramateres de page: impossible de trouver et charger le contenu");

afficherPageAventure($_POST['id'], $_POST['aventure']);

?>
