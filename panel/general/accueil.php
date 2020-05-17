<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/panel/testerConnexion.php');
?>
<h2>Accueil</h2>
<p>
Important: Si vous avez le moindre probleme, allez consulter la section "aide" du site! Elle est la uniquement pour vous aider, n'hesitez pas!
</p>
<div class="divisionPage">
    <div id="aventuresListe"><h3>Vos aventures: </h3></div>
</div>
<!--<div class="divisionPage">
    <div id="newsListe">
        <h3>Dernieres ajouts au panneau de creation: </h3>
        <div id="newListeCont"></div>
        <span id="newsListeActualiser">Actualiser</span>
    </div>
</div>-->

<style>

    .divisionPage
    {
        width: 49%;
        display: inline-block;
        vertical-align: top;
    }
    .divisionPage > div
    {
        margin: 5px;
        border-radius: 5px;
        border: 3px solid #E89323;
        padding: 10px;
    }
    #newsListe
    {
        overflow: auto;
        max-height: 450px;
    }
	
	.rondEtat
	{
		display: inline-block;
		width: 14px;
		height: 14px;
		border-radius: 4px;
		margin-right: 5px;
	}
	.rondEtatGreen
	{
		background: rgb(97, 163, 35);
	}
	.rondEtatRed
	{
		background: rgb(187, 25, 25);
	}

</style>
<script>
    (function(){
        var liste = JSON.parse(getAjaxPage("get:/listeAventures.php", {id: userId}));
        for (var id in liste)
        {
			var rond = $("<div><div>").addClass("rondEtat");
            var boutton = returnBouttonDom(liste[id]['nom'] , function(){
                var id = $(this).attr("data-idAdv");
                afficherAventure(id);
            }).attr("data-idAdv", liste[id]['id']);
			if (parseInt(liste[id]['activee']))
				rond.addClass("rondEtatGreen").attr("title", "Aventure activee");
			else
				rond.addClass("rondEtatRed").attr("title", "Aventure desactivee");
			var divCont = $("<div></div>").appendTo($("#aventuresListe"));
			rond.appendTo(divCont);
            boutton.appendTo(divCont);
        }
        
        /*createButton($("#newsListeActualiser"), function(){
            loadFile($("#newListeCont"), "get:/panel/listeNews.php");
        });
        $("#newsListeActualiser").click();*/
    })();
</script>
