<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/panel/pageAventurePanel.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/editor/editor.php');

?>
<div id="alerts">
</div>
<?php

echo '<h2>Fiche de personage</h2>';

$bdd = new Bdd();
$reqResult = $bdd->query("SELECT * FROM aventures WHERE id = ".$_SESSION['aventureId']);
if (!($aventure = $reqResult->fetch()))
{
    echo 'Erreur dans le chargement';
    exit;
}
?>
<script>setSousMenu("configuration"); </script>
<p>
    La fiche de personage permet de gerer des points de vie, le combat, un inventaire. Tant qu'elle n'est pas activee, si vous tentez de provoquer un combat, d'ajouter des objets, ou autre, cela provoqera une erreur. Vous n'etes pas oblige d'utiliser toutes la fiche: chauqe fonction peut etre activee/desactivee.
</p>
<form>
    <input type="checkbox" name="activerFiche" id="activerFiche" class="checkGliss hideDiv" />
    <label for="activerFiche"><span class="ui"></span>Activer la fiche de personage ?</label>
    <div>
        <label>Nom du personage: </label> <br />
        <input type="text" value="" name="nom" /><br />
        <br />
        <label>Histoire, description... </label> <br />
        <textarea name="description" style="min-height: 200px; max-width: 100%; min-width: 100%;"></textarea> <br />
        <br />
        <h3>Caracteristiques</h3>
        
        <input type="checkbox" name="activerPV" id="activerPV" class="checkGliss hideDiv" />
        <label for="activerPV"><span class="ui"></span>Activer les points de vie?</label>
        <div>
            <p>Les points de vie initiaux sont aussi le maximum de points de vie.</p>
            <label>Points de vie initiaux:</label> <br />
            <input type="text" value="0" name="PV" /> <br />
            <br />
        
            <input type="checkbox" name="activerCombat" id="activerCombat" class="checkGliss hideDiv" />
            <label for="activerCombat"><span class="ui"></span>Activer le combat?</label>
            <div>
                <p>Veuillez indiquer l'attaque et la defense du personage</p>
                <label>Attaque: </label> <br />
                <input type="text" name="attaque" value="0" /> <br/>
                <label>Defense: </label> <br />
                <input type="text" name="defense" value="0" /> <br/>
            </div>
        </div>
        <br />
        <input type="checkbox" name="activerInventaire" id="activerInventaire" class="checkGliss hideDiv" />
        <label for="activerInventaire"><span class="ui"></span>Activer l'inventaire</label>
        <div>
            <p>L'inventaire est actif. Mettez ici les objets dont le joueur dispose au depart.</p>
        </div>
        
        
        
    </div>
</form>
