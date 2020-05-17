$(function(){
    if (typeof ongletDefaut != "undefined") {
        $(ongletDefaut).css("display", "block");
        $(".onglets [data-onglet='"+ongletDefaut+"']").css("background-color", "rgb(210, 210, 210)");
    }
    $(".onglets > ul > li").click(function(){
        $(".onglets > div").css("display", "none");
        $(".onglets > ul > li").css("background-color", "inherit");
        $(this).css("background-color", "rgb(210, 210, 210)");
        $($(this).attr("data-onglet")).css("display", "block").css("opacity", "0").animate({'opacity': "1"}, 400);
    });
});
