<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/valideUser.php');

template_getHeadAll();

echo '<h2>Validation d\'un compte</h2>';

if (!isset($_GET["id"]) || !isset($_GET["code"]))
{
    echo 'Erreur dans les parametres. Essayez de copier-coller l\'adresse dans la barre d\'adresse de votre navigateur';
}
else
{
    echo validerCompteCodeMail($_GET["id"], $_GET["code"]);
}

template_getFootAll();

?>
