<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/admin/access.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
	$bdd = new Bdd();
	$req = $bdd->query("SELECT * FROM users");
	while ($user = $req->fetch()) {
		?>
		<a href="imitterUser.php?id=<?php echo $user['id']; ?>">Imiter l'utilisateur: <?php echo $user['pseudo']; ?></a><br />
		<?php
	}
?>
