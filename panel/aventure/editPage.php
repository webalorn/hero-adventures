<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/panel/pageAventurePanel.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/editor/editor.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/panel/aventure/fenetreDomSelect.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');

if (!(isset($_POST['id']) && isset($_POST['aventure'])))
{
    echo '<div class="redAlert">Erreur dans les parametres de la page</div>';
    exit;
}

$aventure = intval($_POST['aventure']);
$id = intval($_POST['id']);

$bdd = new Bdd();

$req = $bdd->select('aventures', "WHERE id = :id AND userId = :user", array('id' => $aventure, 'user' => $_SESSION['id']));
if (!($req->fetch()))
{
    echo '<div class="redAlert">Erreur lors de l\'authentification de l\'aventure traitee</div>';
    exit;
}

$req = $bdd->select("pages", "WHERE id = :id AND aventure = :adv", array('id' => $id, 'adv' => $aventure));
if (!($pageBdd = $req->fetch()))
{
    echo '<div class="redAlert">Erreur lors de l\'authentification de la page traitee</div>';
    exit;
}

$nom = $pageBdd['nom'];
$contenu = json_decode($pageBdd['contenu'], true);

if (!isset($contenu['contenuText']))
    $contenu['contenuText'] = "";

if (!isset($contenu['typeSuite']))
    $contenu['typeSuite'] = "pages";

echo '<h2>Edition de la page ', $nom, '</h2>';

?>
<?php scriptSlectInArbo($aventure); ?>

<input type="button" value="jouer l'aventure depuis cette page" onclick="window.open('<?php
echo urlReecrite("", $aventure);
?>?pageDeb=<?php echo $id; ?>', '_blank');" />

<form id="editPageForm">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="aventure" value="<?php echo $aventure; ?>" />
    <p>
        <label for="nom">Titre de la page:</label> <br />
        <input type="text" name="titre" id="nom" value="<?php echo $nom; ?>" /><br />
    </p>
    <p>
        <label>Texte de la page:</label><br />
    </p>
    <?php Editor('editor1', 'contenuText', $contenu['contenuText']); ?> <br /> <br /> <br />
    
    <div id="suitePage">
        <h3>Suite apres la page (pages suivantes, mort...)</h3>
        <select name="suite" id="suiteSelect">
            <option value="pages" <?php if ($contenu['typeSuite']  == "pages") echo 'selected'; ?>>Pages suivantes</option>
            <option value="mort" <?php if ($contenu['typeSuite']  == "mort") echo 'selected'; ?>>Perdu</option>
            <option value="fin" <?php if ($contenu['typeSuite']  == "fin") echo 'selected'; ?>>Fin de l'aventure</option>
        </select>
        <div id="pagesSuivantes" data-suite="pages" class="suiteOptionDiv">
            <p>
                En cliquant sur le boutton, vous selectionnerez de nouvelles pages "suite". Ces pages seront les differents choix entre lesquels le visiteurs aura a choisir. Expliquez-les d'abord dans le texte ci-dessus.
            </p>
            <p>
                <input type="button" value="Ajouter une page suite" id="adPageSuite" />
            </p>
        </div>
        <div id="userMort" data-suite="mort" class="suiteOptionDiv">
            <p>
                Si cette option est selectionee, l'utilisateur est mort ou a perdu, et devra recommencer l'aventure. Expliquez-le cependant dans le texte de la page, et detaillez les raisons.
            </p>
        </div>
        <div id="userMort" data-suite="fin" class="suiteOptionDiv">
            <p>
                Si cette option est selectionee, l'utilisateur a termine l'aventure, il a en quelle que sorte gegne. Vous pouvez mettre sur la page un epilogue a l'histoire.
            </p>
        </div>
        <script>
            (function(){
                var changerSelect = function(){
                    $(".suiteOptionDiv").css("display", "none");
                    $(".suiteOptionDiv[data-suite="+$("#suiteSelect").val()+"]").css("display", "block");
                };
                changerSelect();
                $("#suiteSelect").change(changerSelect);
                
                function adElemPage(elem){
                    var cont = $("<div></div>").appendTo($("#pagesSuivantes")).css("margin-left", "20px");
                    var supprimer = $('<img src="/templates/panel/images/supprimer1.png" alt="supprimer" />')
                        .css("max-height", "20px").appendTo(cont).css("cursor", "pointer");
                    var txt = $('<input type="text"/>').attr("name", "pageSuiteTxt[]").appendTo(cont).val(elem.nom)
                        .attr("placeholder", "Texte du lien").css("margin-left", "10px");
                    var nom = $('<span><span style="color: red;">Aucune page selectionne</span></span>').appendTo(cont)
                        .css("font-weight", "bold").css("margin-left", "10px");
                    var id = $('<input type="hidden" value="null" />').attr("name", "pageSuite[]").appendTo(cont);
                    
                    nom.text(elem.nom);
                    id.val(elem.id);
                
                    supprimer.click({'cont': cont}, function(data){
                        data.data.cont.remove();
                    });
                }
                
                <?php
                    if (isset($contenu['pagesSuite']))
                        foreach ($contenu['pagesSuite'] as $page)
                            echo 'adElemPage({"nom": "'.$page['text'].'", "id": parseInt('.$page['page'].')});'."\n";
                ?>
                
                $("#adPageSuite").click(function(){
                    selectionnerDirFile("page", adElemPage);
                });
            })();
        </script>
    </div>
    
    <br />
    <br />
    <input type="button" value="enregistrer" class="submit" />
    
</form>
<script>
    $("#editPageForm .submit").click(function(){
        inLoadPage("start");
        enregistrement($("#editPageForm"), "set:/panel/modifFile.php", function(){
            newAlert("Enregistrement effectue avec succes", "green", true).prependTo($("#page"));
            $('html, body').animate({scrollTop:0}, 'slow');
        }, function(data){
            inLoadPage("stop");
            newAlert("Erreur lors de l'enregistrement", "red", true).prependTo($("#page"));
            $('html, body').animate({scrollTop:0}, 'slow');
        });
    });
</script>

<?php

?>
