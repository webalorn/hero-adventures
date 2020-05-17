<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

function getNews() {
	$bdd = new Bdd();
	$result = $bdd->query("SELECT id, titre, contenu, DATE_FORMAT(date, '%d/%m/%Y %Hh%i') AS date FROM news ORDER BY id DESC");
	$ret = array();
	while ($var = $result->fetch())
		array_push($ret, $var);
	return $ret;
}

?>