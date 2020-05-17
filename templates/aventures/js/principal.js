var pageActu = 'introduction';

$(function(){
    pageReady();
});

function pageReady()
{
    creerLiens();
    $("#mainMenu").css("display", "block");
    
	//loadPageAdv('introduction');
    
}




function saveDivForm(form, params, page, reussi, error) {
    if (typeof params == "undefined")
        var params = {};
    $(form).css("display", "none");
    var loadImgDom = $("<div></div>").css("text-align", "center").insertBefore($(form));
    loadImg().appendTo(loadImgDom);
    
    function setParam(nom, val) {
        nom = (""+nom).split('[');
        if (nom.length == 1)
            params[nom[0]] = val;
        else
        {
            if (typeof params[nom[0]] == "undefined" || typeof params[nom[0]].push == "undefined")
                params[nom[0]] = Array();
            params[nom[0]].push(val);
        }
    }
    
    $(form).find("input, select, textarea").each(function(){
        switch ($(this).attr("type")) {
          case "radio":
            if ($(this).prop("checked"))
                setParam($(this).attr("name"), $(this).attr("value"));
              break;
          default:
            setParam($(this).attr("name"), $(this).val());
        }
    });
    
    ajaxPost(page, params, function(data){ // un enregistrement effectue doit toujours retourner 0
        if (parseInt(data) != 0)
        {
            $(form).css("display", "block");
            loadImgDom.remove();
            if (typeof errorFunction == "undefined") // on affiche le message uniquement si aucune fonction d'erreur n'est definiee
                newAlert("Erreur lors de l'enregistrement", "red", true).prependTo($(form));
            else
                errorFunction(data);
        }
        else {
            $(form).css("display", "block");
            loadImgDom.remove();
            if (typeof rappel != "undefined")
                rappel(data);
            else
                newAlert("Enregistrement effectue avec succes", "green", true).prependTo($(form));
       }
    });
}
