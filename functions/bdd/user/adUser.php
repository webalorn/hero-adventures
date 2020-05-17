<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/classes/exceptions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/valider.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/E-mail.php');

function addUser($pseudo, $mail, $pass)
{
    // verifier validitee parametres
    if (!valider_pseudo($pseudo))
        throw new AddUserException("PSEUDO");
    if (!valider_email($mail))
        throw new AddUserException("EMAIL");
    if (!valider_password($pass))
        throw new AddUserException("PASSWORD");
    
    $bdd = new Bdd();
    
    // verifier pseudo inexistant
    if ( $bdd->select("users", "WHERE pseudo = :pseudo", array("pseudo" => $pseudo))->fetch() )
        throw new AddUserException("PSEUDO_EXISTE");
    
    // inserer dans la base de donnees
    
    $codeValide = defaut_randomStr();
    
    $bdd->insert("users", array(
        "pseudo" => $pseudo ,
        "password" => defaut_encrypt( $pass ) ,
        "email" => $mail ,
        "dateInscrit" => time(),
        "dateActif" => null,
        "codeValide" => $codeValide
    ));
    
    // id utilisateur
    $don = $bdd->select("users", "WHERE pseudo = :pseudo", array("pseudo" => $pseudo))->fetch();
    $id = $don["id"];
    
    // envoyer un mail de confirmation d'inscription
    $urlValide = $_SERVER['HTTP_HOST'].'/site/compte/validerEmail.php?id='.$id.'&code='.$codeValide;
    
    $emailObj = new Email("admin@loup-noir.000webhostapp.com", $mail);
    $emailObj->setSubject("Inscription sur Loup Noir");
    $emailObj->setContent(
'<p>Bonjour, '.$pseudo.'!<br />
Vous vous etes bien inscrit sur <a href="'.$_SERVER['HTTP_HOST'].'" target="_blank">Loup Noir</a>, le site pour vivre des aventures dont vous etes le heros, et en creer de nouvelles.</p>
<p>
Pour valider votre compte sur Loup Noir, accedez a cette page: <a href="'.$urlValide.'" target="_blank">'.$urlValide.'</a> . Vous pourrez ensuite vous connecter.
</p>'
    );
    $emailObj->send();
}

?>
