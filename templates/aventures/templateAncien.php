<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');

function template_getHeader($nomAdv = "", $advId = 0, $userCreateur = false)
{
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $nomAdv; ?> - Aventures - Loup Noir</title>
        <link rel="icon" type="image/png" href="/templates/site/images/favicon.png" />
        <link rel="stylesheet" href="/templates/aventures/css/general.css" />
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
		<script>
			var aventureActu = <?php echo $advId; ?>;
		</script>
        
        <?php include($_SERVER["DOCUMENT_ROOT"].'/analyctis.php'); ?>
        
    </head>
    
    <body>
        <div id="main">
            <header id="header">
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
                <h3><?php echo $nomAdv; ?></h3>
            </header>
            <nav id="mainMenu">
                <ul>
                    <a href="/site/index.php"><li>Retour au site</li></a>
                    <li data-pageAdv="introduction">Introduction et options</li>
					
					<?php if (!isset($_SESSION['id'])) { ?>
                        <a href="/site/inscription.php"><li>Inscription</li></a>
                        <a href="/site/connexion.php"><li>Connexion</li></a>
                    <?php } else { ?>
                        <a href="/site/deconexion.php"><li>Deconnexion</li></a>
                    <?php } ?>
					
					<?php if ($userCreateur) { ?>
						<a href="/panel/?page=/aventure/index.php&adv=<?php echo $advId; ?>"><li>Modifier l'aventure</li></a>
					<?php } ?>
                </ul>
            </nav>
			<div id="chargementImgBarre" style="display: none;">
				<img src="/templates/panel/images/load.gif" alt="Chargement..." />
			</div>
            <div id="page">
<?php
}
function template_getFooter()
{
    ?>
            </div>
        </div>
        
        <script src="/templates/aventures/js/principal.js"></script>
        <script src="/templates/aventures/js/ajax.js"></script>
        <script src="/templates/aventures/js/domActions.js"></script>
        <script src="/templates/aventures/js/fenetres.js"></script>
    </body>
</html>
    <?php
}

?>
