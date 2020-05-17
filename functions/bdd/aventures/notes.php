<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

function verifierIpNotesAdv($idAdv, $ip) {
    $bdd = new Bdd();
    $req = $bdd->select("notesAdvs", "WHERE aventure = :adv AND ip = :ip", array("adv" => $idAdv , "ip" => "".$ip));
    return $req->fetch();
}

function aventureAdNote($idAdv, $note) {
    $ip = $_SERVER["REMOTE_ADDR"];
    if (!verifierIpNotesAdv($idAdv, $ip)) {
        $bdd = new Bdd();
        $req = $bdd->insert("notesAdvs", array("aventure" => $idAdv, "ip" => $ip, "note" => $note));
        return true;
    }
    return false;
}

function aventureRemoveNote($idAdv) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $bdd = new Bdd();
    $req = $bdd->prepare("DELETE FROM notesAdvs WHERE ip = :ip AND aventure = :idAdv");
    $req->execute(array(
        "ip" => $ip,
        "idAdv" => $idAdv
    ));
}

function aventureGetNote($idAdv) {
    $bdd = new Bdd();
    $req = $bdd->query("SELECT AVG(note) AS noteM FROM notesAdvs WHERE aventure = ".intval($idAdv));
    $req = $req->fetch();
    return $req['noteM'];
}

?>
