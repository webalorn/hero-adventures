<div id="aideMenu"><nav>
    <ul>
        <li><a href="/site/aide/">Accueil</a></li>
    </ul>
    <ul>
        <li><a href="/site/aide-aventures">Aventures</a></li>
    </ul>
    <ul>
        <li><a href="/site/aide-creation">Creation</a></li>
        <li><a href="/site/aide-pages-aventures">Les pages</a></li>
    </ul>
</nav></div>
<script>
    $(function(){
        $("#aideMenu ul").each(function(){
            $(this).css("width", $(this).width()+"px");
            $(this).find("li").css("display", "none");
        });
        $("#aideMenu nav").css("height", $("#aideMenu nav").height()+"px");
        $("#aideMenu ul").mouseover(function(){
            $(this).find("li").addClass("displayBlock");
        });
        $("#aideMenu ul").mouseout(function(){
            $(this).find("li").removeClass("displayBlock");
        });
    });
</script>
