function returnBouttonDom(contenu, action)
{
    butt = $("<input type='button' value='"+contenu+"' />");
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
    $("*[data-pageAdv]").each(function(){
        var page = $(this).attr("data-pageAdv");
        $(this).removeAttr("data-pageAdv").css("cursor", "pointer").click(function(){
			if ($(this).attr("data-confirm")) {
				if (confirm("Voulez-vous vraiment recommencer cette partie?"))
					loadPageAdv(page);
			}else
				loadPageAdv(page);
        });
    });
    $("*[data-lien]").each(function(){
        var page = formaterUrl($(this).attr("data-lien"));
        $(this).removeAttr("data-lien").css("cursor", "pointer").click(function(){
            document.location.href = page;
        });
    });
}

var openWindow = function(fen, title) {
    $("body").css("overflow", "hidden");
    if (typeof title == 'undefined')
        var title = "<em>Aucun titre</em>";
    fen = $(fen).parent().css("display", "block");
    fen.children(".fenBarre").children("h3").html(title);
}

function creerFenetres() {
    $(".fenCont").each(function(){
        var fen = $(this).css("display", "block").wrap("<div></div>").parent();
        var fenBarre = $("<div><h3></h3><div></div></div>").addClass("fenBarre").prependTo(fen);
        fen.addClass("fenetre");
        fenBarre.children("div").click(function(){
            $("body").css("overflow", "auto");
            $(this).parent().parent().css("display", "none");
        });
    });
}

function afficheFenBig() {
    var fen = $("<div></div>").addClass("fenImgBig").click(function(){$(this).remove();}).appendTo($("body"));
    var img = $("<img alt='' />").attr("src", $(this).attr("src")).appendTo(fen);
    img.css("margin-top", (fen.height()-img.height())/2 + "px");
    $(window).resize(function(){
        img.css("margin-top", (fen.height()-img.height())/2 + "px");
    });
}

function imagesAdvBigFen() {
    $(".contenuPageAdv img").each(function(){
        if ($(this).attr("data-big"))
            return ;
        $(this).attr("data-big", "ok");
        $(this).click(afficheFenBig);
    });
}
$(function(){
    imagesAdvBigFen();
});
