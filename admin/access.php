<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
	session_start();
	$bdd = new Bdd();
	if (!isset($_SESSION['id'])) {
		echo -1;
		exit;
	}
	$req = $bdd->query("SELECT admin FROM users WHERE id = ".$_SESSION['id']);
	if (!($user = $req->fetch())) {
		echo -2;
		exit;
	}
	if (!$user['admin']) {
		echo -3;
		exit;
	}
?>