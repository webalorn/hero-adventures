<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/panel/pageAventurePanel.php');
//include_once($_SERVER["DOCUMENT_ROOT"].'/functions/get/panel/genereArboAventure.php');

$aventureId = 0;
if (isset($_SESSION['aventureId']))
    $aventureId = $_SESSION['aventureId'];
if (isset($_POST['adv']))
    $aventureId = $_POST['adv'];

//$arborescence = genererArboAventure($_SESSION['aventureId']);

?>
<h2>Fichiers et dossiers</h2>
<p>
    Ici, vous pouvez crer des pages(ou fichiers) et les classer dans des dossiers. Les differentes pages constiturons l'aventure, et vous pourez les relier entre elles. <strong>La page de depart de l'aventure devra imperativement s'appeler <em>index</em> et n'etre dans aucun dossier!</strong> Pour eviter les bugs, ne creez pas d'autre page nomee <em>index</em>.
</p>
<p>
    Pour ouvrir un dossier ou une page, double-cliquez dessus.
</p>
<div id="navigateur">
    <div class="zonePosition"></div>
    <hr />
    <div class="zoneFichiers"></div>
    <hr />
    <div class="zoneAjouts">
        <img src="/templates/panel/images/adDir1.png" id="adDossier" alt="Ajouter un dossier" />
        <img src="/templates/panel/images/adFile1.png" id="adFichier" alt="Ajouter un fichier" />
    </div>
</div>

<style>
    #navigateur
    {
        background: #DFDFDF;
        margin: 5px;
        padding: 10px;
        box-shadow: 0px 0px 6px black;
        border-radius: 5px;
        
        
    }
    .fileDir
    {
        margin: 2px;
        user-select: none;
        cursor: pointer;
    }
    .dossier
    {
        user-select: none;
    }
    .fichier
    {
        user-select: none;
    }
    .fileDir:hover
    {
        background: #EBEBEB;
    }
    .boutActionFileDir:hover
    {
        opacity: 0.4;
    }
    .boutActionFileDir
    {
        cursor: pointer;
        float: right;
        margin-left: 10px;
    }
    .zoneFichiers
    {
        max-height: 400px;
        overflow: auto;
    }
    .zoneAjouts > img
    {
        margin-right: 10px;
        max-height: 35px;
        cursor: pointer;
    }
</style>

<script>
    // deplacement dans l'arborescence et position
    
    var racine = {};
    var dossierActu = racine;
    var positionActu = Array();
    
    function chargerArborescence()
    {
        var fichiers = $("#navigateur > div.zoneFichiers");
        var chemin = $("#navigateur > div.zonePosition");
        chemin.html("");
        $("#zoneAjouts").css("display", "none");
        fichiers.html("");
        loadImg().css("margin", "auto").appendTo(fichiers);
        
        ajaxPost('get:/panel/genereArboAventure.php', {arboIdAventure: <?php echo $aventureId; ?>}, function(data){
            fichiers.html("");
            racine = $.parseJSON(data);
            definirParents(racine, null);
            afficherDir(racine);
            changePosition(positionActu);
            $("#zoneAjouts").css("display", "block");
        }, false, function(){
            fichiers.html("");
            newAlert("ERREUR: Le contenu n'a pas pu etre charge", "red");
        })
    }
    
    function changePosition(posTab)
    {
        var elem = racine;
        for (i in posTab) {
            for (iDir in elem.dossiers) {
                if (elem.dossiers[iDir].id == posTab[i]) {
                    elem = elem.dossiers[iDir];
                    break;
                }
            }
        }
        afficherDir(elem);
    }
    
    function definirParents(dir, parent)
    {
        dir.parent = parent;
        for (var id in dir.dossiers)
            definirParents(dir.dossiers[id], dir);
    }
    
    function recupererPositon(dir, adSep)
    {
        if (dir == null)
            return "";
        var retour = recupererPositon(dir.parent, true) + dir.nom;
        if (adSep)
            retour += ' &#155; ';
        return retour;
    }
    
    function afficherDir(dir)
    {
        dossierActu = dir;
        function getImg(nom)
        {
            return $("<img />").attr("src", "/templates/panel/images/"+nom).css("max-height", "20px");
        }
        
        function afficherElem(titre)
        {
            return $("<div></div>").addClass("fileDir").html(titre).appendTo($("#navigateur > div.zoneFichiers"));
        }
        function afficherFichier(titre, id)
        {
            var elem = afficherElem(titre).addClass("fichier");
            getImg("file1.png").attr("title", "Fichier").prependTo(elem);
            
            getImg("supprimer1.png").attr("title", "Supprimer").appendTo(elem).addClass("boutActionFileDir").click({'id':id, 'nom':titre}, function(data){
                delElem("fichier", data.data.nom, data.data.id);
            });
            /*getImg("edit1.png").attr("title", "Editer").appendTo(elem).addClass("boutActionFileDir").click({'id':id, 'nom':titre}, function(data){
                editFichier(data.data.id, data.data.nom);
            });*/
            elem.dblclick({'id':id, 'nom':titre}, function(data){
                editFichier(data.data.id, data.data.nom);
            });
            
            return elem;
        }
        function afficherDossier(titre, dir)
        {
            var elem = afficherElem(titre).addClass("dossier").dblclick({'dir': dir}, function(data){
                positionActu.push(data.data.dir.id);
                afficherDir(data.data.dir);
            });
            getImg("dir1.png").attr("title", "dossier").prependTo(elem);
            
            getImg("supprimer1.png").attr("title", "Supprimer").appendTo(elem).addClass("boutActionFileDir").click({'dir':dir}, function(data){
                delElem("dossier", data.data.dir.nom, data.data.dir.id);
            });
            getImg("edit1.png").attr("title", "Editer").appendTo(elem).addClass("boutActionFileDir").click({'dir':dir}, function(data){
                editDossier(data.data.dir.id, data.data.dir.nom);
            });
            
            return elem;
        }
        
        $("#navigateur > div.zoneFichiers").html("");
        $("#navigateur > div.zonePosition").html('<strong>'+recupererPositon(dir, false)+'</strong>');
        
        if (dir.parent != null)//dir.parent
            getImg("dirParent1.png").prependTo(afficherElem("Dosier parent").addClass("dossierParent").dblclick({'dir': dir.parent}, function(data){
                    positionActu.pop();
                    afficherDir(data.data.dir);
                }));
        
        for (var id in dir.dossiers)
            afficherDossier(dir.dossiers[id].nom, dir.dossiers[id]);
        for (var id in dir.pages)
             afficherFichier(dir.pages[id].nom, dir.pages[id].id);
        //empechre selection
        $(".fileDir").each(function(){
            this.onselectstart = new Function ("return false");
        });
    }
    chargerArborescence();
    
</script>

<script>
    // edition, supression des fichiers et dossiers
    function addElem(type, parentId)
    {
        var form = $("<p></p>").html('Veuillez indiquer le nom du '+type+': <br />\
            <input name="nom" id="nomDirFile" type="text" />');
        function action (elem, data)
        {
            var nom = elem.find("input[type=text]").val();
            var attente = newFenetre(loadImg().css("display", "block").css("margin", "auto"), "En cours de creation..", false).parents(".fenetreEnsemble");
            var error = function(){ attente.remove(); alerte("Une erreur est survenue durant la creation du "+type+"."); }
            ajaxPost("set:/panel/newDirFile.php", {'type': type, 'parent': parentId, 'nom': nom, 'aventure': aventureActu}, function(data){
                if (parseInt(data) != 0)
                    error();
                else
                {
                    attente.remove();
                    chargerArborescence();
                }
            }, false, error);
        }
        textBox(form, [
            {'text': 'Creer', 'data': {'type': type, 'parent': parent}, 'action': action}, {'text': 'Annuler'}]);
    }
    function delElem(type, nom, id)
    {
        textBoxConfirm("<strong>Voulez-vous reelement supprimer le "+type+" <em>"+nom+"</em> ?</strong>", function(){
            var attente = newFenetre(loadImg().css("display", "block").css("margin", "auto"), "En cours de supression...", false).parents(".fenetreEnsemble");
            var error = function(){ attente.remove(); alerte("Une erreur est survenue durant la supression du "+type+"."); }
            ajaxPost("set:/panel/delDirFile.php", {'type': type, 'id': id, 'aventure': aventureActu}, function(data){
                if (parseInt(data) != 0)
                    error();
                else
                {
                    attente.remove();
                    chargerArborescence();
                }
            }, false, error);
        });
    }
    function editFichier(id, nom)
    {
        chargerPage("/aventure/editPage.php", {'aventure': aventureActu, 'id': id});
    }
    function editDossier(id, nom)
    {
        var form = $("<p></p>").html('Renomer le dossier: <br />\
            <input name="nom" id="nomDir" type="text" value="'+nom+'"/>');
        function action (elem, data)
        {
            var nom = elem.find("input[type=text]").val();
            var attente = newFenetre(loadImg().css("display", "block").css("margin", "auto"), "En cours de modification..", false).parents(".fenetreEnsemble");
            var error = function(){ attente.remove(); alerte("Une erreur est survenue durant la modification du dossier."); }
            ajaxPost("set:/panel/modifDirName.php", {'id': id, 'nom': nom, 'aventure': aventureActu}, function(data){
                if (parseInt(data) != 0)
                    error();
                else
                {
                    attente.remove();
                    chargerArborescence();
                }
            }, false, error);
        }
        textBox(form, [
            {'text': 'Modifier', 'data': {'id': id}, 'action': action}, {'text': 'Annuler'}]);
    }
    
    //evenements
    $("#adDossier").click(function(){addElem("dossier", dossierActu.id);});
    $("#adFichier").click(function(){addElem("fichier", dossierActu.id);});
</script>
