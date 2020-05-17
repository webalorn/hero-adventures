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

$(function(){
    $("#menuShow").click(function(){
        if ($("#page > nav ul").css("display") == "none")
            $("#page > nav ul").clearQueue().css("display", "block").hide(0).show(200);
        else
            $("#page > nav ul").clearQueue().show(0).hide(200);
    });
});

$(function(){ // boites-fenetres
    $("*[data-fen]").each(function(){
        var fen = $($(this).attr("data-fen"))
        fen.addClass("fenetreBoxMoyen").wrap('<div class="cacheBodyFen"></div>');
        $("<input value='fermer' type='button' />").click({'fen': fen}, function(data){ data.data.fen.parent().css("display", "none"); }).appendTo($("<footer></footer>").appendTo(fen));
        $(this).click({'fen' : fen}, function(data) {
            data.data.fen.parent().css("display", "block");
        });
    });
});
