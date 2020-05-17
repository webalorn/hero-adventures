<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

function validerCompteCodeMail($id, $code)
{
    $bdd = new Bdd();
    
    $req = $bdd->select("users", "WHERE id = :id", array("id" => $id));
    if (!($user = $req->fetch()))
        return 'Utilisateur inexistant';
    if ($user['codeValide'] == null)
        return 'Compte deja valide';
    if ($user['codeValide'] != $code)
        return 'Mauvais code de validation';
    
    $bdd->exec('UPDATE users SET codeValide = NULL WHERE id = '.$id);
    
    return 'Compte valide';
}

?>
