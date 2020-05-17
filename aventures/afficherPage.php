<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures/notes.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/gererUser.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/reecriture-url.php');

function secureText($text) {
	return strip_tags($text, "<p><br><br/><span><div><strong><em><i><bold><u><s><sup><sub><a><h1><h2><h3><h4><h5><h6><h7><ul><ol><li><blockquote><img><img/><hr><table><tbody><tr><td><caption><object><param><param/><embed><embed/>");
}

function afficherPageAventure($idPageParam, $idAdv) {
	if (!isset($_SESSION))
		session_start();

	$userPseudo = "Anonyme";
	$userId = 0; $userCreateur = false;
	if (isset($_SESSION['id'])) {
		$userPseudo = $_SESSION['pseudo'];
		$userId = $_SESSION['id'];
	}

	$aventure = getInfosAventure($idAdv);
	if (!isset($aventure['id']))
		erreurHtml("Erreur: aucune aventure correspondante n'exite: ".$idAdv);

	$userCreateur = ($userId == $aventure['userId']);
	if (!$aventure['activee'] && !$userCreateur)
		erreurHtml("Cette aventure n'a pas encore etee activee par son proprietaire, ou a etee desactivee");

	$partie = getPartieUser($idAdv, $userId);

	if ($idPageParam == 'index')
		if (!$idPageParam = getAventurePageIndex($idAdv))
		    erreurHtml("La page nomee index, etant la premiere page de l'aventure, n'a pas etee trouvee! Si vous etes le createur de l'aventure, renomez votre premiere page index.");
	if ($idPageParam == 'introduction')
	{
		echo '<div style="text-align: center;">';
		if (!isset($_SESSION['id']))
			echo '<div class="nonConnecteMsg">Vous n\'etes pas connecte au site. Par consequent, votre avancee est stockee sur votre navigateur sous forme de <em>cookies</em>.
				Vous n\'avez acces a votre partie que sur ce navigateur. Vous pouvez y remedier en vous <a href="/site/inscription.php">inscrivant</a></div>';
		if ($partie == null)
		{
			echo '<input type="button" value="Commencer l\'aventure" data-pageAdv="index" />';
			if (isset($_COOKIE['partie'.intval($idAdv)]) && isset($_SESSION['id']))
			{
				echo '<p>Une aventure enregistree sur le navigateur hors connexion a etee detectee, et vous n\'avez pas enregistre de partie de cette aventure sur ce compte. Voulez-vous continuer la ou vous en etiez?</p>';
				$partieDecode = json_decode($_COOKIE['partie'.intval($idAdv)], true);
				echo '<input type="button" value="Recuperer la partie" data-pageAdv="'.$partieDecode['page'].'" />';
			}
		} else {
			if (intval($partie['termine']))
				echo '<div class="alreadyTermine">Vous avez deja termine cette aventure</div>';
			echo '<input type="button" value="Continuer l\'aventure" data-pageAdv="'.$partie['page'].'" />';
			echo '<br /><br />';
			echo '<input type="button" value="Recommencer l\'aventure" data-confirm="true" data-pageAdv="index" />';
		}
		echo '</div>';
		
		?>
		<h1>Introduction</h1>
		<div class="contenuPageAdv">
			<?php echo secureText($aventure['premierePage']); ?>
		</div>
		<?php
		$note = aventureGetNote($idAdv);
		$noteVal = "aucune note pour le moment";
		$width = 100;
		if ($note > 0) {
			$noteVal = $note.'/10';
			$width = 10 * (10-floatval($note));
		}
		$noteVal = '<span itemprop="ratingValue">'.$noteVal.'</span>';
		$divs = "<div style='width: 100px; height: 30px; background-image: url(\"/templates/aventures/images/etoile.png\");'>
					<div style='width: ".$width."px; height: 30px; background-position: top right; background-image: url(\"/templates/aventures/images/etoileVide.png\"); float: right;'></div>
				</div>";
		$noteVal .= $divs;
		echo '<div id="note"><h3>Note de l\'aventure: </h3><h4 itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">'.$noteVal.'</h4></div>';
		if (!$bddNote = verifierIpNotesAdv($idAdv, $_SERVER["REMOTE_ADDR"]))
		{ ?>
			<div id="selectNote">
				<p>Quelle note donneriez-vous entre 1 et 10 a cette aventure?</p>
				<form>
					<?php for ($i = 1; $i <= 10; $i += 1) { 
						echo '<input type="radio" name="note" value="'.$i.'" id="radioNote'.$i.'" /><label for="radioNote'.$i.'">'.$i.'</label>';
					} ?>
					<br /> <br />
					<input type="button" value="Noter!" id="bouttonNoter" />
				</form>
				<script>
					$(function(){
						$("#bouttonNoter").click(function(){
							inLoadPage("start");
							var params = {'idAdv':<?php echo $idAdv; ?>};
							$("#selectNote").find("input[type=radio]").each(function(){
								if ($(this).prop("checked"))
									params[$(this).attr("name")] = $(this).attr("value");
							});
							ajaxPost("set:/newNoteAventure.php", params, function(data){
								inLoadPage("stop");
								if (parseInt(data) == 0) {
									//newAlert("Votre note a etee prise en compte. Actualisez pour voir.", "green", true).prependTo($(pageContSelect));
									loadPageAdv("introduction");
									$("#selectNote").remove();
								} else {
									newAlert("Erreur: "+data, "red", true).prependTo($(pageContSelect));
								}
								$('html, body').animate({scrollTop:0}, 'slow');
							}, false, function(){
								inLoadPage("stop");
								newAlert("Erreur de la part du serveur", "red", true).prependTo($(pageContSelect));
								$('html, body').animate({scrollTop:0}, 'slow');
							});
						});
						//
					});
				</script>
			</div> <?php
		}
		else { ?>
			<p id="dejaNote">Vous avez deja mis une note: <?php echo $bddNote['note']; ?>/10</p>
			<p><input type="button" id="removeNote" value="Supprimer la note" /></p>
				<script>
					$(function(){
						$("#removeNote").click(function(){
							inLoadPage("start");
							ajaxPost("set:/removeNoteAventure.php", {'idAdv':<?php echo $idAdv; ?>}, function(data){
								loadPageAdv("introduction");
							}, false, function(){
								inLoadPage("stop");
								newAlert("Erreur de la part du serveur", "red", true).prependTo($(pageContSelect));
								$('html, body').animate({scrollTop:0}, 'slow');
							});
						});
						//
					});
				</script>
	    <?php
	    }
		echo '<h3>Partager cette aventure:</h3>';
		$the_permalink2 = function() use ($idAdv){ echo 'http%3A%2F%2Floup-noir%2Ezz%2Emu%2Faventures%2FredirigerAventure%2Ephp%3Fid%3D'.$idAdv; };
		$the_title2 = function() use ($the_permalink2){ $the_permalink2(); };
		?>
		<div>
			<a target="_blank" title="Twitter" href="https://twitter.com/share?url=<?php $the_permalink2(); ?>&text=<?php $the_title2(); ?>&via=loup%20noir" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><img src="/templates/site/images/partager/twitter_icon.png" alt="Twitter" /></a>
			<a target="_blank" title="Facebook" href="https://www.facebook.com/sharer.php?u=<?php $the_permalink2(); ?>&t=<?php $the_title2(); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');return false;"><img src="/templates/site/images/partager/facebook_icon.png" alt="Facebook" /></a>
			<a target="_blank" title="Google +" href="https://plus.google.com/share?url=<?php $the_permalink2(); ?>&hl=fr" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;"><img src="/templates/site/images/partager/gplus_icon.png" alt="Google Plus" /></a>
			<a target="_blank" title="Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php $the_permalink2(); ?>&title=<?php $the_title2(); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;"><img src="/templates/site/images/partager/linkedin_icon.png" alt="Linkedin" /></a>
			<a target="_blank" title="Envoyer par mail" href="mailto:?subject=<?php $the_title2(); ?>&body=Venez%20decouvrir%20cette%20aventure%20dont%20vous%20etes%20le%20heros%20%20<?php $the_permalink2(); ?>" rel="nofollow"><img src="/templates/site/images/partager/email_icon.png" alt="email" /></a>
		</div>
		<?php
		    $createur = infosUser($aventure['userId']);
		echo '<h4>
		    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
		        <span itemprop="name">Cree par: <a href="'.urlRewiteProdil($createur['pseudo'], $createur['id']).'">'.$createur['pseudo'].'</a>
		    </span></span></h4>';
	}
	else
	{
		require("affichePageAdv.php");
	}
}

?>
