<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');

?>


<h2>Creer une nouvelle aventure</h2>

<form id="newAdvForm">
    <label for="newAdvNom">Nom: </label>
    <input id="newAdvNom" name="nom" type="text" /> <br />
    
    <span id="newAdvSubmit">Creer</span>
    <p id="enCreation" style="display: none;">En cours de creation...</p>
    <script>
        loadImg().prependTo($("#enCreation"));
        createButton($("#newAdvSubmit"), function(){
            $("#newAdvSubmit").css("display", "none");
            $("#enCreation").css("display", "block");
            enregistrement($("#newAdvForm"), "set:/creationAventure.php", function(){
                $("#newAdvForm").replaceWith($("<p>Creation de la nouvelle aventure effectuee</p>"));
            }, function(data){
				alerte("La creation de l'aventure a echoucee");
				console.log(data);
                $("#newAdvForm").replaceWith($("<p style='color: red;'>La creation de l'aventure a echoucee</p>"));
			});
        });
    </script>
</form>
