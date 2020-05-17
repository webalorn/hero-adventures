

function returnBouttonDom(contenu, action)
{
    butt = $("<input type='button' />").attr("value", contenu);
    if (typeof action == "function")
        butt.click(action);
    return butt;
}

function createButton(boutton, action)
{
    var text = $(boutton).html();
    var boutton2 = returnBouttonDom(text, action)
        .attr("id", $(boutton).attr("id"))
        .attr("class", $(boutton).attr("class"))
    $(boutton).replaceWith(boutton2);
    $(boutton).remove();
}

function creerLiens()
{
    $("*[data-page]").each(function(){
        var page = $(this).attr("data-page");
        $(this).removeAttr("data-page").css("cursor", "pointer").click(function(){
            chargerPage(page);
        });
    });
    $("*[data-lien]").each(function(){
        var page = formaterUrl($(this).attr("data-lien"));
        $(this).removeAttr("data-lien").css("cursor", "pointer").click(function(){
            document.location.href = page;
        });
    });
    $("#aventureMenu *[data-lien_id_adv]").each(function(){
        var page = formaterUrl($(this).attr("data-lien_id_adv"));
        $(this).removeAttr("data-lien_id_adv").css("cursor", "pointer").click(function(){
            window.open(page+aventureActu, "_blank");
        });
    });
}

var sousManuActu = null;
function setSousMenu(nom) {
    if (nom != sousManuActu) {
        sousManuActu = nom;
        loadFile($("#sousMenu"), "/menus/"+nom+".php", {});
    }
    $("#sousMenu").css("display", "block")
}

