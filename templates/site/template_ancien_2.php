<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');

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
        <link rel="icon" type="image/png" href="/templates/site/images/favicon.png" />
        <link rel="stylesheet" href="/templates/site/css/principal.css" />
        <script src="<?php echo defaut_url_jquery(); ?>"></script>
        <?php include($_SERVER["DOCUMENT_ROOT"].'/analyctis.php');
}
function template_getHeaderPart2()
{
    ?>
    </head>
    
    <body>
        <div id="main">
            <header id="header">
                <h1>Loup Noir</h1>
                <h2>Les aventures dont vous etes le heros</h2>
				<nav id="mainMenu">
					<ul>
						<li><a href="/site/index.php">Accueil</a></li>
						<li><a href="/site/news.php">News</a></li>
						<li><a href="/site/aventures.php">Aventures</a></li>
						<!--<li><a href="/site/aide/">Aide/Tutoriels</a></li>-->
						<!--<a href="/site/forum.php"><li>Forums</li></a>-->
						<?php if (!isset($_SESSION['id'])) { ?>
							<li><a href="/site/inscription.php">Inscription</a></li>
							<li><a href="/site/connexion.php">Connexion</a></li>
						<?php } else { ?>
							<!--<a href="/site/compte.php"><li>Mon compte</li></a>-->
							<li><a href="/panel/">Creation d'aventures</a></li>
							<li><a href="/site/deconexion.php">Deconnexion</a></li>
						<?php } ?>
					</ul>
				</nav>
            </header>
            <div id="page">
    <?php // entre ces deux fontions se trouvera le code de la page
}function template_getHeader($titre = "")
{
	template_getHeaderPart1($titre);
	template_getHeaderPart2();
}
    
function template_getFooter()
{
    ?>
            </div>
            <footer id="footer">
				<?php function the_permalink(){ echo 'http://loup-noir.000webhostapp.com'; } ?>
				<?php function the_title(){ echo 'Loup Noir, les aventures dont vous etes le heros: vivez, creez!'; } ?>
				<div>
					<div>
						<a target="_blank" title="Twitter" href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>&via=loup%20noir" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><img src="/templates/site/images/partager/twitter_icon.png" alt="Twitter" /></a>
						<a target="_blank" title="Facebook" href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');return false;"><img src="/templates/site/images/partager/facebook_icon.png" alt="Facebook" /></a>
						<a target="_blank" title="Google +" href="https://plus.google.com/share?url=<?php the_permalink(); ?>&hl=fr" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;"><img src="/templates/site/images/partager/gplus_icon.png" alt="Google Plus" /></a>
						<a target="_blank" title="Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;"><img src="/templates/site/images/partager/linkedin_icon.png" alt="Linkedin" /></a>
						<a target="_blank" title="Envoyer par mail" href="mailto:?subject=<?php the_title(); ?>&body=Venez%20vivre%20ou%20creez%20des%20aventures%20dont%20vous%20etes%20le%20heros%20sur%20%20<?php the_permalink(); ?>" rel="nofollow"><img src="http://korben.info/wp-content/themes/korben2013/hab/email_icon.png" alt="email" /></a>
					</div>
					<!--<div>
						<a target="_blank" title="Flattr !" href="https://flattr.com/submit/auto?user_id=loupNoir&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&description=Loup%20Noir:%20les%20aventures%20dont%20vous%20etes%20le%20heros&language=fr_FR&tags=blog&category=text" rel="nofollow"><img src="http://korben.info/wp-content/themes/korben2013/hab/flattr_icon.png" alt="Flattr !" /></a>
					</div>-->
				</div>
                <p>Toute copie partielle ou totale du site interdite sans autorisation du <a href="/site/webmaster.php">webmaster</a></p>
				<p><a href="/site/conditions.php">Conditions d'utilisation</a></p>
				<p>Référencé par: 
					<a href="http://www.hannuaire.fr/" title="Annuaire référencement gratuit"><img src="http://www.hannuaire.fr/i/rouge.png" alt="Annuaire web" style="border:0"/></a>
				</p>
            </footer>
        </div>
        
        <script src="/templates/site/js/general.js"></script>
        <script src="/templates/site/js/formulaires.js"></script>
    </body>
</html>
    <?php
}

?>
