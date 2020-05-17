var aventures = {};
var aventureActu = null;
var aventureActuName = null;
var isActuAventure = false;
var defaultPage = "/general/accueil.php";
var pageActuelle = defaultPage, paramsPageActuelle = {};

$(function(){
    var racineScripts = "/templates/panel/js/";
    var scripts = ['racine:/templates/plugins/colors/js/colpick.js' ];
    var nbCharges = 0;
    for (var i in scripts)
    {
        var url = scripts[i];
        if (url.indexOf("racine:") == 0)
            url =  url.substr(7);
        else
            url = racineScripts+url;
        $.getScript(url, function(){
            nbCharges += 1;
            if (nbCharges == scripts.length)
            {
                pageReady();
            }
        });
    }
});

function pageReady()
{
    creerLiens();
    $("#mainMenu").css("display", "block");
    
    var paramsPage = paramsLodPagePannel;
    if (typeof paramsPage['page'] != "undefined")
    {
        if (typeof paramsPage['par'] == "undefined")
            paramsPage['par'] = {};
        if (typeof paramsPage['adv'] != "undefined")
            setAventureActu(parseInt(paramsPage['adv']), function(){
                chargerPage(paramsPage['page'], $.parseJSON(paramsPage['par']));
            });
        else
            chargerPage(paramsPage['page'], paramsPage['par']);
    }
    else
        chargerPage(defaultPage);
    
}
