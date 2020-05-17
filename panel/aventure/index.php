<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/panel/pageAventurePanel.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures/notes.php');

echo '<h2>Aventure '.$_SESSION['aventureName'].'</h2>';

$bdd = new Bdd();
$reqResult = $bdd->query("SELECT * FROM aventures WHERE id = ".$_SESSION['aventureId']);
if (!($aventure = $reqResult->fetch()))
{
    echo 'Erreur dans le chargement';
    exit;
}

if (!$aventure['activee'])
{ ?>

<div class="aventureInactiveBox">
    Tant que votre aventure n'est pas activee (page configuration), persone n'y a acces appart vous, et vous ne pouvez pas la diffuser. 
</div>

<style>
    .aventureInactiveBox
    {
        padding: 10px;
        text-align: center;
        background: rgba(255, 0, 0, 0.05);
        border: 2px solid black;
        border-radius: 7px;
    }
</style>

<?php
}

?>
<p>
    Vous pouvez configurer la page d'accueil, decrivant votre aventure, sur la page configuration. Sur cette meme page, vous purrez activer votre aventure, afin qu'elle soit visible par les autres membres. Par defaut, seul vous pouvez y acceder, ce qui vous permet de la developper sans problemmes
</p>
<h3>Activer l'aventure ou non ?</h3>
<p>
    Une fois que l'aventure est activee, tout le monde peut y jouer. Ainsi, pour eviter des problemes, ne l'activez pas tant que vous n'avez pas termine! Si une joueur commencait sans l'equipement complet, parceque vous n'aviez pas tout mis? Si il se retrouve sur une page sans suite possible? Ces problemes peuvent etre evites en n'activant pas l'aventure avant la fin de son developpement.
</p>

<h2>Statistiques</h2>
<?php
    $note = aventureGetNote($_SESSION['aventureId']);
	$noteVal = "aucune note pour le moment";
	$width = 100;
	if ($note > 0) {
		$noteVal = $note.'/10';
		$width = 10 * (10-floatval($note));
	}
	$divs = "<div style='width: 100px; height: 30px; background-image: url(\"/templates/aventures/images/etoile.png\");'>
				<div style='width: ".$width."px; height: 30px; background-position: top right; background-image: url(\"/templates/aventures/images/etoileVide.png\"); float: right;'></div>
			</div>";
	$noteVal .= $divs;
	echo '<div id="note"><h3>Note de l\'aventure moyenne: </h3><h4>'.$noteVal.'</h4></div>';
?>
<div id="statNePart">
    <?php
        $reqResult = $bdd->query("SELECT COUNT(*) as nbPart FROM parties WHERE aventure = ".$_SESSION['aventureId']);
        $nbPart = $reqResult->fetch();
        $nbPart = intval($nbPart['nbPart']);
        if ($nbPart > 1)
            echo 'Actuellement, '.$nbPart.' joueurs inscrits ont commences une partie sur cette aventure';
        else if ($nbPart == 1)
            echo 'Actuellement, 1 joueur inscrit a commence une partie sur cette aventure';
        else
            'Actuellement, aucun joueur inscrit n\'a commence de partie sur cette aventure';
    ?>
</div>
