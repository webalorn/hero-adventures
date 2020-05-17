function formaterUrl(url)
{
    var racine = "/panel", racineGet = "/functions/get", racineSet = "/functions/set";
    if (url.indexOf("racine:") == 0)
        return url.substr(7);
    if (url.indexOf("get:") == 0)
        return racineGet + url.substr(4);
    if (url.indexOf("set:") == 0)
        return racineSet + url.substr(4);
    return racine+url;
}

function ajaxPost(page, params, rappel, retourner, errorFunction)
{
    if (typeof params == "undefined")
        params = {};
    page = formaterUrl(page);
    
    var retour = "ERROR";
    if (typeof retourner != "undefined" && retourner)
        $.ajaxSetup({async: false});
    
    $.ajax({
        url : page,
        type : 'POST',
        data : params,
        success: function(pageResult, statut)
        {
            if (parseInt(pageResult) == -1) // le retour doit etre -1 si l'utilisateur est deconnecte
                deconnecte();
            else
            {
                if (typeof rappel == "function")
                    rappel(pageResult, statut);
                if (typeof retourner != "undefined" && retourner)
                    retour = pageResult;
            }
        },
        error: function(resultat, statut, erreur){ if (typeof errorFunction == "function") errorFunction(resultat, statut, erreur); },
        dataType: "text"
    });
    $.ajaxSetup({async: true});
    return retour;
}

function getAjaxPage(page, params)
{
    return ajaxPost(page, params, function(){}, true);
}

function chargerBarreAventureinfos()
{
    aventureActuName = getAjaxPage("get:/aventureNameWithId.php", {'id':aventureActu});
    $("#advMenuName").text(aventureActuName);
}

function setAventureActu(id, rappel)
{
    if (typeof rappel == "undefined")
        rappel = function(){};
    aventureActu = id;
    chargerBarreAventureinfos();
    ajaxPost("set:/aventureIdActu.php", {'id':id}, rappel);
}

function afficherAventure(id)
{
    setAventureActu(id, function(){
        chargerPage("/aventure/index.php");
    });
}

function inLoadPage(action)
{
    if (typeof action == "undefined" || action == "start")
    {
        $(pageContSelect).css("display", "none");
        $("#chargementImgBarre").css("display", "block");
    }
    else
    {
        $("#chargementImgBarre").css("display", "none");
        $(pageContSelect).css("display", "block");
    }
}

function deconnecte()
{
    textBox("Vous etes deconnecte. Veuillez vous reconnecter.", {action:function(){
        newFenetre("", "Connexion");
    }});
}

function chargerPage(page, params, rappel)
{
    inLoadPage("start");
    if (typeof params == "undefined")
        params = {};
    
    ajaxPost(page, params, function(pageResult)
    {
        pageActu = page;
        $(pageContSelect).html(pageResult);
        creerLiens();
        inLoadPage("stop");
        if (typeof rappel != "undefined" && rappel)
            rappel(pageResult);
    }, false, function(resultat, statut, erreur) {
        alerte("Erreur: la page n'a pas pu etre charge. Retour de la requete: "+erreur);
        inLoadPage("stop");
    });
}
function loadPageAdv(id) {
	chargerPage('racine:/aventures/getPage.php', {'id': id, 'aventure': aventureActu}, function(){
	    imagesAdvBigFen();
	});
}

function loadImg(type)
{
    var repertoire = "/templates/panel/images/";
    var nom = "";
    switch (type)
    {
      case "page":
        nom = "load.gif";
        break;
      default:
        nom = "load2.gif";
    }
    return $("<img />").attr("alt", "Loading...").attr("src", repertoire+nom);
}

function loadFile(element, page, params)
{
    $(element).html("");
    loadImg().css("display", "block").css("margin", "auto").css("margin-top", "6px").css("margin-bottom", "6px").appendTo($(element));
    ajaxPost(page, params, function(contenu)
    {
        $(element).html(contenu);
    }, false, function(){
        $(element).html("");
        newAlert("Erreur: le contenu n'a pas pu etre charge", "red").appendTo($(element));
    })
}
