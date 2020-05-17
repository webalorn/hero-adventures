// boites, fenetres

function newFenetre(contenu, titre, fermer)
{
    var ensemble = $("<div></div>").addClass("fenetreEnsemble").appendTo($("body"));
    var fond = $("<div></div>").addClass("fenetreFond").appendTo(ensemble);
    var fenetre = $("<div></div>").addClass("fenetre").appendTo(fond);
    
    if (typeof titre != "undefined" && titre)
    {
        if (typeof titre == "string")
            titre = $("<div></div>").html(titre);
        var titreDom = $("<div></div>").addClass("fenetreTitre").appendTo(fenetre);
        $(titre).appendTo(titreDom);
    }
    
    if (typeof contenu != "undefined")
        contenu = $("<div></div>").html(contenu);
    else
        var contenu = $("<div></div>");
    contenu = $(contenu).addClass("contenuFenetre").appendTo(fenetre);
    
    if (!(fermer === false))
        returnBouttonDom("Fermer", function(){$(this).parents(".fenetreEnsemble").remove();}).appendTo($("<div></div>").addClass("fenetreFermerBarre").appendTo(contenu));
    
    return fenetre;
}

function textBox(texte, bouttons)
{
    if (typeof texte.css != "undefined")
        var contenu = $(texte);
    else
        var contenu = $("<div></div>").html(texte);
    var barreBouttons = $("<div></div>").addClass("barreBouttonsTextBox").appendTo(contenu);
    
    if (typeof bouttons == "undefined" || !bouttons)
        bouttons = [{}];
    
    for (var id in bouttons)
    {
        var txt = "OK"; var act = function(){}; var data = {};
        if (typeof bouttons[id].text != "undefined")
            txt = bouttons[id].text;
        if (typeof bouttons[id].action != "undefined")
            act = bouttons[id].action;
        if (typeof bouttons[id].data != "undefined")
            data = bouttons[id].data;
        
        returnBouttonDom(txt).appendTo(barreBouttons).click({'action': act, 'data': data}, function(data){
            if (!(data.data.action($(this).parents(".textBox"), data.data.data) === false))
                $(this).parents(".fenetreEnsemble").remove();
        });
    }
    return newFenetre(contenu, "", false).addClass("textBox");
}

function textBoxConfirm(texte, action)
{
    textBox(texte, [{action: action} , {text:"Anuler"}]);
}

function alerte(texte)
{
    var box = textBox(texte).css("text-align", "center");
    box.find(".barreBouttonsTextBox").css("text-align", "center");
    return box;
}

// alertes, boites

function deleteAlertes()
{
    $(".alerteColor").remove();
}

function newAlert(message, color, supr)
{
    if (supr)
        deleteAlertes();
    return $('<div class="'+color+'Alert alerteColor"></div>').html(message);
}
