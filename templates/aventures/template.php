<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/site_template_decoupe.php');

function template_getHeaderPart1($nomAdv = "", $advId = 0, $userCreateur = false)
{
    if (!isset($_SESSION))
        session_start();
    template_site_decoupe_head($nomAdv." - Aventures");
    ?>
        <link rel="stylesheet" href="/templates/aventures/css/aventures_flat.css" />
		<script>
			var aventureActu = <?php echo $advId; ?>;
			var pageContSelect = "#contenu";
		</script>
	<?php
}
function template_getHeaderPart2($nomAdv = "", $advId = 0, $userCreateur = false)
{
    template_site_decoupe_titres();
    echo '<h3 itemprop="name">'.$nomAdv.'</h3>';
	template_site_decoupe_menu();
	?>
				<li><a href="/site/index.php">Retour au site</a></li>
				<li data-pageAdv="introduction"><a href="#" onclick="return false;">Introduction et options</a></li>
				
				<?php if (!isset($_SESSION['id'])) { ?>
					<li><a href="/site/inscription.php">Inscription</a></li>
					<li><a href="/site/connexion.php">Connexion</a></li>
				<?php } else { ?>
					<li><a href="/site/compte/">Connecte comme: <em><?php echo $_SESSION['pseudo']; ?></em></a></li>
				<?php } if ($userCreateur) { ?>
					<li><a href="/panel/?page=/aventure/index.php&adv=<?php echo $advId; ?>">Modifier l'aventure</a></li>
				<?php } ?>
    <?php template_site_decoupe_endMenu(); ?>
	    <div id="chargementImgBarre" style="display: none;">
		    <img src="/templates/panel/images/load.gif" alt="Chargement..." />
	    </div>
    
    <?php template_site_decoupe_page();
}
function template_getHeader($nomAdv = "", $advId = 0, $userCreateur = false)
{
	template_getHeaderPart1($nomAdv, $advId, $userCreateur);
	template_getHeaderPart2($nomAdv, $advId, $userCreateur);
}
    
function template_getFooter()
{
    template_site_decoupe_endPage();
    template_site_decoupe_footer();
    ?>
        <script src="/templates/aventures/js/principal.js"></script>
        <script src="/templates/aventures/js/ajax.js"></script>
        <script src="/templates/aventures/js/domActions.js"></script>
        <script src="/templates/aventures/js/fenetres.js"></script>
    <?php
    template_site_decoupe_pageEnd();
}

?><?php
/*
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
        <link rel="icon" type="image/png" href="/templates/site/images/favicon_flat.png" />
        <link rel="stylesheet" href="/templates/site/css/flat_design.css" />
        <link rel="stylesheet" href="/templates/aventures/css/aventures_flat.css" />
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
		<script>
			var aventureActu = <?php echo $advId; ?>;
			var pageContSelect = "#contenu";
		</script>
        <?php include($_SERVER["DOCUMENT_ROOT"].'/analyctis.php');
}
function template_getHeaderPart2($nomAdv = "", $advId = 0, $userCreateur = false)
{
    ?>
    </head>
    
    <body id="page">
        <header id="header">
            <div>
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
			    <h3><?php echo $nomAdv; ?></h3>
			</div>
        </header>
		<nav id="mainMenu">
			<div id="menuShow">Menu</div>
			<ul>
				<li><a href="/site/index.php">Retour au site</a></li>
				<li data-pageAdv="introduction"><a href="#" onclick="return false;">Introduction et options</a></li>
				
				<?php if (!isset($_SESSION['id'])) { ?>
					<li><a href="/site/inscription.php">Inscription</a></li>
					<li><a href="/site/connexion.php">Connexion</a></li>
				<?php } ?>
				
				<?php if ($userCreateur) { ?>
					<li><a href="/panel/?page=/aventure/index.php&adv=<?php echo $advId; ?>">Modifier l'aventure</a></li>
				<?php } ?>
			</ul>
		</nav>
	    <div id="chargementImgBarre" style="display: none;">
		    <img src="/templates/panel/images/load.gif" alt="Chargement..." />
	    </div>
        <div id="parentContenu">
            <section id="contenu">
    <?php // entre ces deux fontions se trouvera le code de la page
}function template_getHeader($nomAdv = "", $advId = 0, $userCreateur = false)
{
	template_getHeaderPart1($nomAdv, $advId, $userCreateur);
	template_getHeaderPart2($nomAdv, $advId, $userCreateur);
}
    
function template_getFooter()
{
    ?>
            </section>
        </div>
        <footer id="footer">
            <p>Toute copie partielle ou totale du site interdite sans autorisation du <a href="/site/webmaster.php">webmaster</a> - <a href="/site/conditions.php">Conditions d'utilisation</a></p>
			</p>
        </footer>
        
        <script src="/templates/site/js/general.js"></script>
        
        <script src="/templates/aventures/js/principal.js"></script>
        <script src="/templates/aventures/js/ajax.js"></script>
        <script src="/templates/aventures/js/domActions.js"></script>
        <script src="/templates/aventures/js/fenetres.js"></script>
        <?php
            if (!isset($_SESSION['id'])) { // resoudre les problemes d'enregistrement avec les cookies
                echo '<script>$(function(){loadPageAdv("introduction");});</script>';
            }
        ?>
    </body>
</html>
    <?php
}
*/
?>
