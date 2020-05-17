<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/site_template_decoupe.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/messages.php');

function template_getHeaderPart1($titre = "")
{
    template_site_decoupe_head($titre);
}
function template_getHeaderPart2()
{
    template_site_decoupe_titres();
    template_site_decoupe_menu();
    ?>
				<li><a href="/site/index.php">Accueil</a></li><!--
				--><li><a href="/site/news.php">News</a></li><!--
				--><li><a href="/site/aventures.php">Aventures</a></li><!--
				--><li><a href="/site/aide/">Aide</a></li><!--
				--><!--<li><a href="/site/aide/">Aide/Tutoriels</a></li>--><!--
				--><!--<a href="/site/forum.php"><li>Forums</li></a>--><!--
				<?php if (!isset($_SESSION['id'])) { ?>
					--><li><a href="/site/inscription.php">Inscription</a></li><!--
					--><li><a href="/site/connexion.php">Connexion</a></li><!--
				<?php } else { ?>
					--><li><a href="/site/compte/">Mon compte</a></li><!--
					--><li><a href="/site/compte/messagerie.php">Messages<?php
					    $mess = new MessagerieObjet();
					    $nbMsg = $mess->nbNonLus($_SESSION['id']);
					    if ($nbMsg > 0)
					        echo "<span class='nbrDansMenu' id='menuRondNbNonLus'>".$nbMsg."</span>";
					?></a></li><!--
					--><li><a href="/panel/">Creation d'aventures</a></li><!--
					--><li><a href="/site/deconexion.php">Deconnexion</a></li><!--
				<?php } ?>-->
    <?php
    template_site_decoupe_endMenu();
    template_site_decoupe_page();
     // entre ces deux fontions se trouvera le code de la page
}

function template_getHeader($titre = "")
{
	template_getHeaderPart1($titre);
	template_getHeaderPart2();
}
    
function template_getFooter()
{
    template_site_decoupe_endPage();
    template_site_decoupe_footer();
    ?>
        <script src="/templates/site/js/formulaires.js"></script>
    <?php
    template_site_decoupe_pageEnd();
}

?><?php /*

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

function template_getHeaderPart1($titre = "")
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
function template_getHeaderPart2()
{
    ?>
    </head>
    
    <body id="page">
        <header id="header">
            <div>
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
            </div>
        </header>
		<nav id="mainMenu">
		    <div id="menuShow">Menu</div>
			<ul>
				<li><a href="/site/index.php">Accueil</a></li><!--
				--><li><a href="/site/news.php">News</a></li><!--
				--><li><a href="/site/aventures.php">Aventures</a></li><!--
				--><!--<li><a href="/site/aide/">Aide/Tutoriels</a></li>--><!--
				--><!--<a href="/site/forum.php"><li>Forums</li></a>--><!--
				<?php if (!isset($_SESSION['id'])) { ?>
					--><li><a href="/site/inscription.php">Inscription</a></li><!--
					--><li><a href="/site/connexion.php">Connexion</a></li><!--
				<?php } else { ?>
					--><li><a href="/site/compte/">Mon compte</a></li><!--
					--><li><a href="/panel/">Creation d'aventures</a></li><!--
					--><li><a href="/site/deconexion.php">Deconnexion</a></li><!--
				<?php } ?>-->
				
			</ul>
		</nav>
        <div id="parentContenu">
            <section id="contenu">
    <?php // entre ces deux fontions se trouvera le code de la page
}

function template_getHeader($titre = "")
{
	template_getHeaderPart1($titre);
	template_getHeaderPart2();
}
    
function template_getFooter()
{
    ?>
            </section>
        </div>
        <footer id="footer">
			<?php function the_permalink(){ echo 'http://loup-noir.000webhostapp.com'; } ?>
			<?php function the_title(){ echo 'Loup Noir, les aventures dont vous etes le heros: vivez, creez!'; } ?>
			<div>
				<div>
				    <?php
					echoPartageLiens('http://loup-noir.000webhostapp.com', 'Loup Noir, les aventures dont vous etes le heros: jouer-y, creez-les!', 'Le site Loup Noir vous permet de jouer a des aventures, des histoires, ou le heros, c\'est VOUS! Vous pouvez egallement creer et develloper vos propres histoires en ligne. http://loup-noir.000webhostapp.com');
					?>
				</div>
				<!--<div>
					<a target="_blank" title="Flattr !" href="https://flattr.com/submit/auto?user_id=loupNoir&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&description=Loup%20Noir:%20les%20aventures%20dont%20vous%20etes%20le%20heros&language=fr_FR&tags=blog&category=text" rel="nofollow"><img src="http://korben.info/wp-content/themes/korben2013/hab/flattr_icon.png" alt="Flattr !" /></a>
				</div>-->
			</div>
            <p>Toute copie partielle ou totale du site interdite sans autorisation du <a href="/site/webmaster.php">webmaster</a> - <a href="/site/conditions.php">Conditions d'utilisation</a></p>
			<p>Version 1.2 - Heberge par <a href="http://api.hostinger.fr/redir/5031330" target="_blank">Hostinger</a></p>
        </footer>
        
        <script src="/templates/site/js/general.js"></script>
        <script src="/templates/site/js/formulaires.js"></script>
    </body>
</html>
    <?php
}
*/
?>
