<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

function getInfosAventure($idAdv)
{
    $bdd = new Bdd();
    if ( $adv = $bdd->query("SELECT * FROM aventures WHERE id = ".intval($idAdv)) -> fetch() )
        return $adv;
    return array();
}

function listeAventuresVisibles(){
	$bdd = new Bdd();
    $advs = $bdd->query("SELECT * FROM aventures WHERE activee = 1");
    $tab = array();
	while ($adv = $advs->fetch()) {
		$user = $bdd->query("SELECT pseudo FROM users WHERE id = ".$adv['userId']);
		$userName = "";
		if ($user = $user->fetch())
			$userName = $user['pseudo'];
		$adv['userName'] = $userName;
		array_push($tab, $adv);
	}
	return $tab;
}

function urlReecrite($nomAventure, $id) {
    if (!$nomAventure) {
        $adv = getInfosAventure($id);
        if ($adv)
            $nomAventure = $adv['nom'];
    }
    $url = "/aventure-".$id."-";
    $adTiret = false;
    $nomAventure = str_split($nomAventure);
    foreach ($nomAventure as $id => $car) {
        if (!preg_match("#[a-zA-Z0-9]#", "".$car)) {
            if ($adTiret) {
                $adTiret = false;
                $url .= "-";
            }
        } else {
            $adTiret = true;
            $url .= $car;
        }
    }
    if (!$adTiret)
        $url = substr($url, 0, strlen($url)-1);
    return $url;
}

function getAventurePageIndex($idAdv)
{
	$bdd = new Bdd();
    if ( $page = $bdd->query("SELECT * FROM pages WHERE aventure = ".intval($idAdv)." AND nom = 'index'") -> fetch() )
        return $page['id'];
    return 0;
}

function getPartieUser($idAdv, $user)
{
	$user = intval($user);
	if ($user == 0 && isset($_COOKIE['partie'.intval($idAdv)])) {
		$adv = json_decode($_COOKIE['partie'.intval($idAdv)], true);
		$adv['perso'] = json_decode($adv['perso'], true);
        return $adv;
	}
	$bdd = new Bdd();
    if ($user != 0 && $adv = $bdd->query("SELECT * FROM parties WHERE aventure = ".intval($idAdv)." AND userId = ".intval($user)) -> fetch() ) {
		$adv['perso'] = json_decode($adv['perso'], true);
        return $adv;
	}
    return null;
}

function creerNouvellePartie($idAdv, $user)
{
	$user = intval($user);
	$partieBase = array(
		"userId" => $user , "aventure" => $idAdv , "page" => "index" , "termine" => 0 , "perso" => "{}"
	);
	$bdd = new Bdd();
	if ($user == 0)
	{
		setcookie('partie'.intval($idAdv), json_encode($partieBase), time()+3*360*24*60*60, '/');
		$_COOKIE['partie'.intval($idAdv)] = json_encode($partieBase);
	}
	else if (getPartieUser($idAdv, $user) == null)
	{
		$bdd->insert("parties", $partieBase);
	}
	else
	{
		$bdd->update("parties", "WHERE aventure = ".intval($idAdv)." AND userId = ".intval($user), $partieBase);
	}
}

function setInfosPartie($infos, $idAdv, $user)
{
	$partie = getPartieUser($idAdv, $user);
	if ($partie == null)
		creerNouvellePartie($idAdv, $user);
	$partie = getPartieUser($idAdv, $user);
	foreach ($infos as $cle => $val) {
		$partie[$cle] = $val;
	}
	$partie['perso'] = json_encode($partie['perso']);
	if (intval($user) == 0)
	{
		setcookie('partie'.intval($idAdv), json_encode(bddFormateTab($partie)), time()+2*360*24*60*60, '/');
	}
	else
	{
		$bdd = new Bdd();
		$bdd->update("parties", "WHERE aventure = ".intval($idAdv)." AND userId = ".intval($user), bddFormateTab($partie));
	}
}

?>
