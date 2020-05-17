<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/reecriture-url.php');

template_getHeaderPart1("Liste des aventures");
?>
<style>
	ul.listeAventures {
		display: block;
		padding: 0px;
	}
	.listeAventures li {
		display: block;
		padding: 4px 10px;
		background-color: rgba(255, 221, 221, 1);
		margin-bottom: 20px;
	}
	.listeAventures h3 {
		font-weight: normal;
		text-align: center;
	}
	.auteur {
		font-weight: bold;
		display: inline-block;
		float: right;
	}
	.wordPar {
		display: inline-block;
	}
	.aventure h3 a.lienAventure{
		display: inline-block;
		float: left;
	}
	.aventure h4{
		margin-left: 10px;
	}
	.synopsis {
		text-align: justify;
		padding: 15px;
		max-height: 250px;
		overflow: auto;
		border-top: 2px solid white;
		margin-left: 10px;
	}
	.wordDuree {
		font-weight: normal;
	}
</style>
<?php
template_getHeaderPart2();
?>

<h2>Liste de toutes les aventures</h2>
<p class="alinea">
	Inscrivez-vous et créez vos propres histoires, vos propres aventures, puis activez-les pour les publier et les faires apparaitre dans cette liste!
</p>
<ul class="listeAventures">
<?php

$aventures = listeAventuresVisibles();
foreach ($aventures as $adv) {
	
	$duree = "<em>Non specifiee</em>";
	if ($adv['duree']  == "1") $duree = '1-5 minutes';
    if ($adv['duree']  == "2") $duree = '5-10 minutes';
    if ($adv['duree']  == "3") $duree = '10-20 minutes';
    if ($adv['duree']  == "4") $duree = '20-30 minutes';
    if ($adv['duree']  == "5") $duree = '30-45 minutes';
    if ($adv['duree']  == "6") $duree = '45 minutes - 1H';
    if ($adv['duree']  == "7") $duree = 'plus d\'une heure';
	
	echo'<li class="aventure">
			<h3>
				<a class="lienAventure" href="'.urlReecrite($adv['nom'], $adv['id']).'">'.$adv['nom'].'</a> <span class="wordPar">par</span> <a class="auteur" href="'
				.urlRewiteProdil($adv['userName'], $adv['userId']).'">'.$adv['userName'].'</a>
			</h3>
			<h4><span class="wordDuree">Duree : </span>'.$duree.'</h4>
			<div class="synopsis">'.$adv['synopsis'].'</div>
		</li>';
}
?>
</ul>
<?php
if (count($aventures) == 0)
	echo '<p class="alinea">Pas encore d\'aventures? Créez vous meme les première du site en vous inscrivant gratuitement</p>';
template_getFooter();

?>
