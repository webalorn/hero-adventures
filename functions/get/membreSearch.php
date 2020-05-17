<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

$tab = array();
if (isset($_POST['chaine'])) {
    $bdd = new Bdd();
    $req = $bdd->prepare("SELECT pseudo FROM users WHERE pseudo LIKE concat('%',:chaine,'%')");
    $req->execute(array("chaine" => $_POST['chaine']));
    while ($l = $req->fetch())
        $tab[] = $l['pseudo'];
}
echo JSON_encode($tab);

?>
