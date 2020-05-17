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

function htmlUrlEncoder(url)
{
    var cars = [["\t", "%09"],[" ", "%20"],['!','%21'],['"','%22'],['#','%23'],['%','%25'],['&','%26'],['(','%28'],[')','%29'],['*','%2A'],['+','%2B'],[',','%2C'],['.','%2E'],['/','%2F'],[':','%3A'],[';','%3B'],['<','%3C'],['=','%3D'],['>','%3E'],['?','%3F'],['@','%40'],['[','%5B'],['\\','%5C'],[']','%5D'],['^','%5E'],["'",'%60'],['{','%7B'],['|','%7C'],['}','%7D'],['~','%7E']];
    var result = "";
    for (var i1 in url)
    {
        var caractere = url[i1];
        for (var i2 in cars)
            if (caractere == cars[i2][0])
                caractere = cars[i2][1];
        result += caractere;
    }
    return url;
}

function rewiteUrl(page, aventure, params1, newEntreeHistory)
{
    var paramsVide = true;
    for (i in params1)
    { paramsVide = false; break; }
    page = htmlUrlEncoder(page);
    aventure = htmlUrlEncoder(aventure);
    params = htmlUrlEncoder(JSON.stringify(params1));
    var url = "?page="+page;
    if (isActuAventure)
        url += "&adv="+aventure;
    if (!paramsVide)
        url += "&par="+params;
    if (typeof newEntreeHistory === "undefined" || newEntreeHistory)
        history.pushState({'page': page, 'aventure': aventure, 'params': params}, "", url);
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

function enregistrement(form, page, rappel, errorFunction)
{
    inLoadPage("start");
    for (id in CKEDITOR.instances)
        $("#"+id).text(CKEDITOR.instances[id].getData());
    
    var params = {};
    
    function setParam(nom, val) {
        nom = nom+"";
        nom = nom.split('[');
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
    
    var errorFunct = function(data, statut, erreur) {
        if (typeof errorFunction == "undefined") // on affiche le message uniquement si aucune fonction d'erreur n'est definiee
            textBox("L'enregistrement a echoue");
        else
            errorFunction(data);
    }
    
    ajaxPost(page, params, function(data){ // un enregistrement effectue doit toujours retourner 0
        if (parseInt(data) != 0)
            errorFunct(data);
        else if (typeof rappel != "undefined")
            rappel(data);
    }, false, errorFunct);
    inLoadPage("stop");
}



function inLoadPage(action)
{
    if (typeof action == "undefined" || action == "start")
    {
        $("#page").css("display", "none");
        $("#chargementImgBarre").css("display", "block");
    }
    else
    {
        $("#chargementImgBarre").css("display", "none");
        $("#page").css("display", "block");
    }
}

function deconnecte()
{
    textBox("Vous etes deconnecte par le serveur. Vous pouvez vous reconnectez sur <a href='/site/connexion.php' target='_blank'>cette page</a>. Une fois que ce sera fait, cliquez sur OK et rettentez l'action que vous venez d'effectuer.<br /><br/>Si vous avez des donnes non-enregistrees sur cette page, elle seront conservee tant que vous ne fermez pas cette page.", {action:function(){
        newFenetre("", "Connexion");
    }});
}

function chargerPage(page, params, rappel, options)
{
    inLoadPage("start");
    if (typeof params == "undefined")
        params = {};
    
    if (typeof options === "undefined")
        options = {};
    if (typeof options.newEntreeHistory === "undefined")
        options.newEntreeHistory = true;
    
    ajaxPost(page, params, function(pageResult)
    {
        $(".cke_reset_all").remove();
        paramsPageActuelle = params;
        pageActuelle = page;
        
        $("#aventureMenu").css("display", "none");
        isActuAventure = false;
        $("#sousMenu").css("display", "none");
        
        $("#page").html(pageResult);
        rewiteUrl(pageActuelle, aventureActu, params, options.newEntreeHistory);
        
        creerLiens();
        colorSelectInPageDiv();
        
        inLoadPage("stop");
        if (typeof rappel != "undefined" && rappel)
            rappel(pageResult);
    }, false, function(resultat, statut, erreur) {
        // si erreur
        alerte("Erreur: la page n'a pas pu etre charge. Retour de la requete: "+erreur);
        inLoadPage("stop");
    });
}

function refreshPage()
{ chargerPage(pageActuelle, paramsPageActuelle, function(){}, {'newEntreeHistory': false}); }

window.onpopstate = function(event)
{
    aventureActu = event.state.aventure;
    chargerPage(event.state.page, $.parseJSON(event.state.params), function(){}, {'newEntreeHistory': false});
};

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
    return $("<img />").attr("alt", "loading...").attr("src", repertoire+nom);
}

function loadFile(element, page, params)
{
    $(element).html("");
    loadImg().css("display", "block").css("margin", "auto").css("margin-top", "6px").css("margin-bottom", "6px").appendTo($(element));
    ajaxPost(page, params, function(contenu)
    {
        $(element).html(contenu);
        creerLiens();
    }, false, function(){
        $(element).html("");
        newAlert("Erreur: le contenu n'a pas pu etre charge", "red").appendTo($(element));
    })
}
