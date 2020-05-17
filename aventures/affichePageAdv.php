<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');

$bdd = new Bdd();
if ( $page = $bdd->query("SELECT * FROM pages WHERE id = ".intval($idPageParam)) -> fetch() )
{
	$contenu = json_decode($page['contenu'], true);
	if (!isset($contenu['version']))
		erreurHtml("Aucun contenu sur la page, elle n'a jamais etee modifiee");
	if (intval($contenu['version']) == 1)
	{
		setInfosPartie(array("page" => $idPageParam), $aventure['id'], $userId);
		?>
		 <div id="barreBouttons">
		    <div id="bouttonNotes" onclick="openWindow('#fenNotes', 'Feuille de notes');" title="Notes"></div>
		 </div>
		<?php
		echo '<div class="contenuPageAdv">';
			echo secureText($contenu['contenuText']);
		echo '</div><div class="suitePageAdv">';
			if ($contenu['typeSuite'] == "pages")
			{
				foreach ($contenu['pagesSuite'] as $suite) {
					echo '<input type="button" value="'.$suite['text'].'" data-pageAdv="'.$suite['page'].'" /><br />';
				}
			}
			if ($contenu['typeSuite'] == "mort")
			{
				echo '<p class="paraMort">Vous avez perdu! Vous devez recomencer l\'aventure...</p>';
				echo '<p><input type="button" value="Recommencer l\'aventure" data-pageAdv="index" /></p>';
			}
			if ($contenu['typeSuite'] == "fin")
			{
				setInfosPartie(array("termine" => 1), $aventure['id'], $userId);
				echo '<p class="paraFin">Vous avez termine cette aventure! Vous pouvez a tout moment recommencer depuis la page d\'introduction</p>';
			}
		echo '</div>';
		//fenetres
		?>
		<div class="fenCont" id="fenNotes">
		    <div>
		        <h2>Feuille de notes</h2>
		        <p>Les feuille de notes vous permet de prendre des notes durant l'aventure. Le contenu est libre, seul vous pouvez la voir.</p>
		        <textarea style="width: 100%; height: 300px;" name="feuilleNotes"><?php
		                if (isset($partie['feuilleNotes']))
		                    echo $partie['feuilleNotes'];
		        ?></textarea>
		        <br />
		        <input type="button" value="enregistrer" id="saveNotesAdv" />
		    </div>
		</div>
		<script>
		    creerFenetres();
		    $("#saveNotesAdv").click(function(){
		        saveDivForm("#fenNotes", {'idAdv': aventureActu}, "set:/aventures/saveNotes.php");
		    });
		</script>
		<?php
	}
	else
		erreurHtml("Mauvaise declaration de la page: enregistrement corrompu");
}
else
	erreurHtml("Cette page de cette aventure n'exite pas ou plus. Veuillez retourner sur l'introduction et faire \"poursuivre l'aventure\".");
?>
