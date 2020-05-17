<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');

function template_getHeaderPart1($nomAdv = "", $advId = 0, $userCreateur = false)
{
    if (!isset($_SESSION))
        session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $nomAdv; ?> - Aventures - Loup Noir</title>
        <link rel="icon" type="image/png" href="/templates/site/images/favicon.png" />
        <link rel="stylesheet" href="/templates/site/css/principal.css" />
        <link rel="stylesheet" href="/templates/aventures/css/aventures.css" />
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
		<script>
			var aventureActu = <?php echo $advId; ?>;
		</script>
        <?php include($_SERVER["DOCUMENT_ROOT"].'/analyctis.php');
}
function template_getHeaderPart2($nomAdv = "", $advId = 0, $userCreateur = false)
{
    ?>
    </head>
    <body>
        <div id="main">
            <header id="header">
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
				<h3><?php echo $nomAdv; ?></h3>
				<nav id="mainMenu">
					<ul>
						<li><a href="/site/index.php">Retour au site</a></li>
						<li data-pageAdv="introduction"><a href="#" onclick="return false;">Introduction et options</a></li>
						
						<?php if (!isset($_SESSION['id'])) { ?>
							<li><a href="/site/inscription.php">Inscription</a></li>
							<li><a href="/site/connexion.php">Connexion</a></li>
						<?php } else { ?>
							<li><a href="/site/deconexion.php">Deconnexion</a></li>
						<?php } ?>
						
						<?php if ($userCreateur) { ?>
							<li><a href="/panel/?page=/aventure/index.php&adv=<?php echo $advId; ?>">Modifier l'aventure</a></li>
						<?php } ?>
					</ul>
				</nav>
            </header>
			<div id="chargementImgBarre" style="display: none;">
				<img src="/templates/panel/images/load.gif" alt="Chargement..." />
			</div>
            <div id="page">
    <?php // entre ces deux fontions se trouvera le code de la page
}function template_getHeader($nomAdv = "", $advId = 0, $userCreateur = false)
{
	template_getHeaderPart1($nomAdv, $advId, $userCreateur);
	template_getHeaderPart2($nomAdv, $advId, $userCreateur);
}
    
function template_getFooter()
{
    ?>
            </div>
            <footer id="footer">
                <p>Toute copie partielle ou totale du site interdite sans autorisation du <a href="/site/webmaster.php">webmaster</a></p>
				<p><a href="/site/conditions.php">Conditions d'utilisation</a></p>
            </footer>
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
