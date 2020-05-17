<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');

$titre = ""; $contenuText = ""; $suiteType = "pages"; $pagesSuite = array();

if (!isset($_POST['titre']) || !isset($_POST['contenuText']) || !isset($_POST['suite']) || !isset($_POST['aventure']) || !isset($_POST['id']))
{
    echo 'Erreur parametres';
    exit;
}

$titre = htmlspecialchars($_POST['titre']);
$contenuText = $_POST['contenuText'];
$suiteType = $_POST['suite'];
$aventure = intval($_POST['aventure']);
$id = intval($_POST['id']);

if (isset($_POST['pageSuite']) && isset($_POST['pageSuiteTxt']))
{
    $pagesSuiteVar = $_POST['pageSuite'];
    $pagesSuiteTxt = $_POST['pageSuiteTxt'];
    foreach ($pagesSuiteVar as $i => $val)
        $pagesSuite[$i] = array(
            "page" => intval($pagesSuiteVar[$i]),
            "text" => htmlspecialchars("".$pagesSuiteTxt[$i])
        );
}

$bdd = new Bdd();

$req = $bdd->select('aventures', "WHERE id = :id AND userId = :user", array('id' => $aventure, 'user' => $_SESSION['id']));
if (!($req->fetch()))
{
    echo 'Erreur lors de l\'authentification de l\'aventure traitee';
    exit;
}

$req = $bdd->select("pages", "WHERE id = :id AND aventure = :adv", array('id' => $id, 'adv' => $aventure));
if (!($pageBdd = $req->fetch()))
{
    echo 'Erreur lors de l\'authentification de la page traitee';
    exit;
}

$contenu = array(
    "version" => 1,
    "contenuText" => $contenuText,
    "typeSuite" => $suiteType,
    "pagesSuite" => $pagesSuite
);

$params = array(
    "nom" => $titre,
    "contenu" => JSON_encode($contenu)
);

$bdd->update("pages", "WHERE id = ".$id, $params);
echo '0';

?>
