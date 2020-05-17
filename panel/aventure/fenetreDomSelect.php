<?php
    
    function scriptSlectInArbo($aventureId)
    {
        ?>
<script>
var fenDomSelect = {
    racine: {},
    dossierActu: this.racine,
    navigateurDefaut: $('<div class="fenNavigateur"><div class="zonePosition"></div> \
    <hr /> \
    <div class="zoneFichiers"></div> \
    </div>'),
    navigateur: this.navigateurDefaut,
    fenetre: $("<div></div>"),
    selection: "page",
    rappelFunction: function(){},
    
    chargerArborescence: function(dossiersUniquement)
    {
        var fichiers = this.navigateur.find(".zoneFichiers");
        var chemin = this.navigateur.find(".zonePosition");
        chemin.html("");
        this.navigateur.find(".zoneAjouts").css("display", "none");
        fichiers.html("");
        loadImg().css("margin", "auto").appendTo(fichiers);
        
        ajaxPost('get:/panel/genereArboAventure.php', {arboIdAventure: <?php echo $aventureId; ?>}, function(data){
            fichiers.html("");
            fenDomSelect.racine = $.parseJSON(data);
            fenDomSelect.definirParents(fenDomSelect.racine, null);
            fenDomSelect.afficherDir(fenDomSelect.racine);
            fenDomSelect.navigateur.find(".zoneAjouts").css("display", "block");
        }, false, function(){
            fichiers.html("");
            newAlert("ERREUR: Le contenu n'a pas pu etre charge", "red");
        })
    },
    
    definirParents: function(dir, parent)
    {
        dir.parent = parent;
        for (var id in dir.dossiers)
            this.definirParents(dir.dossiers[id], dir);
    },
    
    recupererPositon: function (dir, adSep)
    {
        if (dir == null)
            return "";
        var retour = this.recupererPositon(dir.parent, true) + dir.nom;
        if (adSep)
            retour += ' &#155; ';
        return retour;
    },
    
    afficherDir: function (dir)
    {
        this.dossierActu = dir;
        function getImg(nom)
        {
            return $("<img />").attr("src", "/templates/panel/images/"+nom).css("max-height", "20px");
        }
        
        function afficherElem(titre)
        {
            return $("<div></div>").addClass("fileDir").html(titre).appendTo(fenDomSelect.navigateur.find(".zoneFichiers"));
        }
        function afficherFichier(titre, id)
        {
            var elem = afficherElem(titre).addClass("fichier");
            getImg("file1.png").attr("title", "Fichier").prependTo(elem);
            if (fenDomSelect.selection == "page")
            {
                elem.click({'id':id, 'nom':titre}, function(data){
                    fenDomSelect.fenetre.remove();
                    fenDomSelect.rappelFunction(data.data);
                });
            }
            else
                elem.css("background", "transparent").css("cursor", "auto");
            
            return elem;
        }
        function afficherDossier(titre, dir)
        {
            var elem = afficherElem(titre).addClass("dossier").click({'dir': dir}, function(data){
                fenDomSelect.afficherDir(data.data.dir);
            });
            getImg("dir1.png").attr("title", "dossier").prependTo(elem);
            
            return elem;
        }
        
        this.navigateur.find(".zoneFichiers").html("");
        this.navigateur.find(".zonePosition").html('<strong>'+this.recupererPositon(dir, false)+'</strong>');
        
        if (dir.parent != null)//dir.parent
            getImg("dirParent1.png").prependTo(afficherElem("Dosier parent").addClass("dossierParent").click({'dir': dir.parent}, function(data){
                    fenDomSelect.afficherDir(data.data.dir);
                }));
        
        for (var id in dir.dossiers)
            afficherDossier(dir.dossiers[id].nom, dir.dossiers[id]);
        for (var id in dir.pages)
             afficherFichier(dir.pages[id].nom, dir.pages[id].id);
        
        //empecher selection
        $(".fileDir").each(function(){
            this.onselectstart = new Function ("return false");
        });
    },
    
    chargerBouttons: function()
    {
        returnBouttonDom("Annuler").click({'parent': this}, function(data) {
            data.data.parent.fenetre.remove();
        }).appendTo($("<div></div>").css("text-align", "center").css("padding", "5px").insertAfter(this.navigateur));
        if (this.selection == "dossier")
        {
            returnBouttonDom("Selectionner ce dossier").click({'parent': this}, function(data) {
                data.data.parent.fenetre.remove();
                data.data.parent.rappelFunction(data.data.parent.dossierActu);
            }).appendTo($("<div></div>").css("text-align", "center").css("padding", "5px").insertAfter(this.navigateur));
        }
    }
    
};

function selectionnerDirFile(type, rappel)
{
    fenDomSelect.rappelFunction = rappel;
    fenDomSelect.selection = type;
    fenDomSelect.fenetre = newFenetre(fenDomSelect.navigateurDefaut, "Slectionner un "+type, false).parents(".fenetreEnsemble");
    fenDomSelect.navigateur = fenDomSelect.fenetre.find(".fenNavigateur");
    fenDomSelect.chargerArborescence();
    fenDomSelect.chargerBouttons();
}
    
</script>
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
    .zoneFichiers
    {
        max-height: 400px;
        overflow: auto;
    }
</style>
        <?php
    }
    
?>
