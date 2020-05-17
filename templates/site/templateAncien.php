<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');

function template_getHeader($titre = "")
{
    if (!isset($_SESSION))
        session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $titre; ?> - Loup Noir</title>
        <link rel="icon" type="image/png" href="/templates/site/images/favicon.png" />
        <link rel="stylesheet" href="/templates/site/css/general.css" />
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
        
        <?php include($_SERVER["DOCUMENT_ROOT"].'/analyctis.php'); ?>
        
    </head>
    
    <body>
        <div id="main">
            <a href="/site/index.php"><header id="header">
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
            </header></a>
            <nav id="mainMenu">
                <ul>
                    <a href="/site/index.php"><li>Accueil</li></a>
                    <a href="/site/news.php"><li>News</li></a>
                    <a href="/site/aventures.php"><li>Aventures</li></a>
                    <a href="/site/aide.php"><li>Aide/Tutoriels</li></a>
                    <!--<a href="/site/forum.php"><li>Forums</li></a>-->
                    <?php if (!isset($_SESSION['id'])) { ?>
                        <a href="/site/inscription.php"><li>Inscription</li></a>
                        <a href="/site/connexion.php"><li>Connexion</li></a>
                    <?php } else { ?>
                        <!--<a href="/site/compte.php"><li>Mon compte</li></a>-->
                        <a href="/panel/"><li>Creation d'aventures</li></a>
                        <a href="/site/deconexion.php"><li>Deconnexion</li></a>
                    <?php } ?>
                </ul>
            </nav>
            <div id="page">
    <?php // entre ces deux fontions se trouvera le code de la page
}
    
function template_getFooter()
{
    ?>
            </div>
            <hr id="ligneSepFoter" />
            <footer id="footer">
                <p>Toute copie partielle ou totale du site interdite sans autorisation du <a href="/site/webmaster.php">webmaster</a></p>
            </footer>
        </div>
        
        <script src="/templates/site/js/general.js"></script>
        <script src="/templates/site/js/formulaires.js"></script>
    </body>
</html>
    <?php
}

?>
