<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/admin/access.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
	if (!isset($_GET['id'])) {
	    echo 'Id manquant';
	    exit;
	}
	$bdd = new Bdd();
	$req = $bdd->query("SELECT * FROM users WHERE id=".intval($_GET['id']));
	if (!$user = $req->fetch()) {
		echo 'Utilisateur inexistant';
		exit;
	}
	if (!isset($_SESSION))
        session_start();
    ini_set("session.gc_maxlifetime", 10800);
    $_SESSION['id'] = $user['id'];
    $_SESSION['pseudo'] = $user['pseudo'];
    header('Location: /');
?>
