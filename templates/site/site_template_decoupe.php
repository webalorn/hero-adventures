<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');

function echoPartageLiens($lien, $titre, $text) {
    $lien = urlencode($lien); $titre = urlencode($titre); $text = urlencode($text);
    $fenetreOpen = "javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');return false;";
    ?>
        <a target="_blank" title="Twitter" href="https://twitter.com/share?url=<?php echo $lien; ?>&text=<?php echo $titre; ?>&via=loup%20noir" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><img src="/templates/site/images/partager/twitter_icon.png" alt="Twitter" /></a>
					<a target="_blank" title="Facebook" href="https://www.facebook.com/sharer.php?u=<?php echo $lien; ?>&t=<?php echo $titre; ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');return false;"><img src="/templates/site/images/partager/facebook_icon.png" alt="Facebook" /></a>
					<a target="_blank" title="Google +" href="https://plus.google.com/share?url=<?php echo $lien; ?>&hl=fr" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;"><img src="/templates/site/images/partager/gplus_icon.png" alt="Google Plus" /></a>
					<a target="_blank" title="Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $lien; ?>&title=<?php echo $titre; ?>" rel="nofollow" onclick="javascript:window.open(this.href, '','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;"><img src="/templates/site/images/partager/linkedin_icon.png" alt="Linkedin" /></a>
					<a target="_blank" title="Envoyer par mail" href="mailto:?subject=<?php echo $titre; ?>&body=<?php echo $text; ?>" rel="nofollow"><img src="/templates/site/images/partager/email_icon.png" alt="email" /></a>
    <?php
}

function template_site_decoupe_head($titre = "")
{
    if (!isset($_SESSION))
        session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $titre; ?> - Loup Noir</title>
        <link rel="icon" type="image/png" href="/templates/site/images/favicon_flat.png" />
        <link rel="stylesheet" href="/templates/site/css/flat_design.css" />
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
        <?php include($_SERVER["DOCUMENT_ROOT"].'/analyctis.php');
}
function template_site_decoupe_titres()
{
    ?>
    </head>
    
    <body id="page">
        <header id="header">
            <div>
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
    <?php
}
function template_site_decoupe_menu()
{
    ?>
            </div>
        </header>
		<nav id="mainMenu">
		    <div id="menuShow">Menu</div>
			<ul>
    <?php
}
function template_site_decoupe_endMenu()
{
    ?>
			</ul>
		</nav>
    <?php
}
function template_site_decoupe_page()
{
    ?>
        <div id="parentContenu">
            <section id="contenu" itemscope itemtype="http://schema.org/Article">
    <?php // entre ces deux fontions se trouvera le code de la page
}
    
function template_site_decoupe_endPage()
{
    ?>
            </section>
        </div>
    <?php
}
function template_site_decoupe_footer()
{
    ?>
        <footer id="footer">
			<div>
				<div>
				    <?php
					echoPartageLiens('http://loup-noir.000webhostapp.com', 'Loup Noir, les aventures dont vous etes le heros: jouer-y, creez-les!', 'Le site Loup Noir vous permet de jouer a des aventures, des histoires, ou le heros, c\'est VOUS! Vous pouvez egallement creer et develloper vos propres histoires en ligne. http://loup-noir.000webhostapp.com');
					?>
				</div>
			</div>
            <p>Toute copie partielle ou totale du site interdite sans autorisation du <a href="/site/webmaster.php">webmaster</a> - <a href="/site/conditions.php">Conditions d'utilisation</a></p>
			<p>Version 1.4 - Heberge par <a href="http://api.hostinger.fr/redir/5031330" target="_blank">Hostinger</a></p>
        </footer>
    <?php
}
function template_site_decoupe_pageEnd()
{
    ?>
        <script src="/templates/site/js/general.js"></script>
        <script src="/templates/site/js/onglets.js"></script>
    </body>
</html>
    <?php
}

?>
