(function(){
setInterval(function(){
    $(".cke_dialog_title").each(function(){
        if (!$(this).attr("data-traite") && $(this).text() == "Propriétés de l'image")
        {
            $(this).attr("data-traite", "ok");
            var content = $(this).parent().find(".cke_dialog_contents");
            var liens = $("<p></p>").html("Pour des raisons de limitation d'hebergement, les images, ne peuvent etre habergee sur ce serveur. <br />"
                        + "Vous pouvez cependant utiliser un des herbergeurs externe de la liste ci-dessous. <br />"
                        +"Vous n'avez qu'a heberger vos images, puis a copier-coller l'<strong>URL</strong> donnee.<br /><br />"
                        + "<a href='http://www.zupimages.net/historique.php' target='_blank'>Zupimages</a><br />"
                        + "<a href='http://www.hostingpics.net/' target='_blank'>HostingPics</a><br />"
                        + "<a href='http://www.casimages.com/' target='_blank'>Casimages</a><br />"
                        + "<a href='http://uprapide.com/' target='_blank'>UpRapide</a><br />"
                        + "<a href='http://imagesia.com/' target='_blank'>Imagesia</a><br />"
                        //+"<br/>Ou Uploadez avec ce module de Casimages:<br/>"
                        //+'<iframe src="http://www.casimages.com/module_ext.php" width="300" height="100" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
                        ).css("overflow", "hidden").css("width", "600px").css("word-wrap", "break-word");
            liens.find("a").css("text-decoration", "underline")
            var boutton = $("<input type='button' value='Uploader une image' />").click({'liens': liens}, function(data){
                $(this).replaceWith(data.data.liens);
            });
            var para = $("<div></div>").css("margin", "15px");
            boutton.appendTo(para);
            para.prependTo(content);
        }
    });
}, 500);})();
