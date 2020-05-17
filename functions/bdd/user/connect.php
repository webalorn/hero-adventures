<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

function connexion($pseudo, $password)
{
    $bdd = new Bdd();
    $req = $bdd->select("users", "WHERE pseudo = :pseudo", array("pseudo" => $pseudo));
    
    if (!($user = $req->fetch()))
        return "ERROR";
    $encrypt = defaut_encrypt( $password );
    if ($encrypt != $user['password'] && $encrypt != $user['passReset'])
        return "ERROR";
    
    $actue = time();
    $bdd->exec('UPDATE users SET dateActif = '.$actue.' WHERE id = '.$user["id"]);
    
    // variables session
    if (!isset($_SESSION))
        session_start();
    ini_set("session.gc_maxlifetime", 10800);
    $_SESSION['id'] = $user['id'];
    $_SESSION['pseudo'] = $user['pseudo'];
    
    return 'SUCCESS';
}

?>
