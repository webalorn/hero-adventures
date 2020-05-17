<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/editor/editor.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');

function template_getPage($params)
{
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Pannel - creation d'aventures - Le Loup Noir</title>
        <link rel="stylesheet" href="/templates/panel/css/general.css" />
        <link rel="stylesheet" href="/templates/plugins/colors/css/colpick.css" type="text/css"/>
        <script>
            var userId = <?php echo $_SESSION['id']; ?>;
            var paramsLodPagePannel = <?php echo JSON_encode($params); ?>;
        </script>
        <link rel="icon" type="image/png" href="/templates/site/images/favicon_flat.png" />
    </head>
    <body>
        <div id="mainMenu">
            <ul>
                <li data-page="/general/accueil.php">Accueil</li>
                <li data-page="/general/creerAventure.php">Nouvelle aventure</li>
                <!--<li data-page="/general/statistiques.php">Statistiques</li>-->
                <li data-lien="racine:/"><a href="/">Retour sur le site</a></li>
                <li data-lien="racine:/site/deconexion.php">Deconnexion</li>
            </ul>
        </div>
        <div id="aventureMenu">
            <div id="advMenuName"></div>
            <ul>
                <li data-page="/aventure/index.php">General</li>
                <li data-page="/aventure/configuration.php">Configuration</li>
                <li data-page="/aventure/pages.php">Pages</li>
                <li data-lien_id_adv="racine:/aventures/redirigerAventure.php?id=" data-target="_blank">Voir l'aventure</li>
            </ul>
        </div>
        <div id="sousMenu"></div>
        <div id="chargementImgBarre">
            <img src="/templates/panel/images/load.gif" alt="Chargement..." />
        </div>
        <div id="page"></div>
        <div id="footer"></div>
        
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
        <?php integrerEditorScript(); ?>
        <script src="/templates/panel/js/principal.js"></script>
        
        <script src="/templates/panel/js/ajax.js"></script>
        <script src="/templates/panel/js/autres.js"></script>
        <script src="/templates/panel/js/fenetres.js"></script>
        <script src="/templates/panel/js/domActions.js"></script>
    </body>
</html>
    <?php
}

?>
