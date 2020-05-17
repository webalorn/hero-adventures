<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/panel/pageAventurePanel.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/editor/editor.php');

?>
<div id="alerts">
</div>
<?php

echo '<h2>Configuration: '.$_SESSION['aventureName'].'</h2>';

$bdd = new Bdd();
$reqResult = $bdd->query("SELECT * FROM aventures WHERE id = ".$_SESSION['aventureId']);
if (!($aventure = $reqResult->fetch()))
{
    echo 'Erreur dans le chargement';
    exit;
}

?>
<script>
    //setSousMenu("configuration");
</script>
<form id="configAdvForm">
    <p>
        <label for="nom">Nom de l'aventure:</label> <br />
        <input type="text" name="nom" id="nom" value="<?php echo $aventure['nom']; ?>" style="width: 300px;" /> <br />
    </p>
    <p>
        <label>Le synopsis: un court texte pour decrire brievement l'aventure et donner envie d'y jouer.</label><br />
    </p>
    <textarea name="synopsis" style="width: 80%; height: 150px;"><?php echo $aventure['synopsis']; ?></textarea>
	<br />
    <p>
        <label>Introduction de l'aventure: </label><br />
        <br />
        L'introduction n'est PAS le debut. Elle doit juste presenter l'univers la situation, mais pas proposer de choix.
    </p>
    <?php Editor('editor1', 'premierePage', $aventure['premierePage']); ?> <br /> <br /> <br />
    <p>
        <label>Publier l'aventure (devient visible pour tout le monde)</label> <br />
        <input type="radio" name="activee" value="0" id="falseActivee" <?php if (!$aventure['activee']){ echo 'checked'; } ?> />
        <label for="falseActivee">Desactiver</label> <br />
        
        <input type="radio" name="activee" value="1" id="trueActivee" <?php if ($aventure['activee']){ echo 'checked'; } ?> />
        <label for="trueActivee">Activer</label> <br />
    </p>
	<p>
		Duree de l'aventure (environ) : <br />
		<select name="duree" id="duree">
            <option value="0" <?php if ($aventure['duree']  == "0") echo 'selected'; ?>>Non specifie</option>
            <option value="1" <?php if ($aventure['duree'] == "1") echo 'selected'; ?>>1-5 minutes</option>
            <option value="2" <?php if ($aventure['duree']  == "2") echo 'selected'; ?>>5-10 minutes</option>
            <option value="3" <?php if ($aventure['duree']  == "3") echo 'selected'; ?>>10-20 minutes</option>
            <option value="4" <?php if ($aventure['duree']  == "4") echo 'selected'; ?>>20-30 minutes</option>
            <option value="5" <?php if ($aventure['duree']  == "5") echo 'selected'; ?>>30-45 minutes</option>
            <option value="6" <?php if ($aventure['duree']  == "6") echo 'selected'; ?>>45 minutes - 1H</option>
            <option value="7" <?php if ($aventure['duree']  == "7") echo 'selected'; ?>>plus d'une heure</option>
        </select>
	</p>
    <p>
        <div id="advConfigSubmit">Enregistrer</div>
    </p>
    <input type="button" id="deleteAdv" value="Supprimer l'aventure" style="color: red;" />
    <script>
        createButton($("#advConfigSubmit"), function(){
            inLoadPage("start");
            ajaxPost("set:/aventureIdActu.php", {'id':aventureActu}, function(){
                enregistrement($("#configAdvForm"), "set:/configAventure.php", function(){
                    newAlert("Enregistrement effectue avec succes", "green").appendTo($("#alerts").html(""));
                    $('html, body').animate({scrollTop:0}, 'slow');
                });
            });
        });
        $("#deleteAdv").click(function(){
            textBoxConfirm("Etes vous sur de vouloir supprimer cette aventure? Aucune recupperation des donnees ne sera ensuite possible!", function(){
                textBoxConfirm("Veuillez confirmer une derniere fois la suppression de cette aventure.", function(){
                    inLoadPage("start");
                    ajaxPost("set:/panel/deleteAventure.php", {id: aventureActu}, function(result){
                        if (parseInt(result) == 0)
                        {
                            chargerPage(defaultPage, {}, function(){
                                newAlert("Aventure bien supprimee", "green").prependTo($("#page"));
                            });
                        }
                        else
                        {
                            newAlert("Erreur lors de la suppression", "red", true).prependTo($("#page"));
                            inLoadPage("stop");
                        }
                    });
                });
            });
        });
    </script>
</form>
