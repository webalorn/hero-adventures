<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

template_getHeader("Webmaster");
?>

<p class="alinea">
    Createur du site : <em>Theophane Vallaeys</em>. Contact: <a id="mailWeba" href="mailto:webalorn <arobase@> gmail point com" target="_blank">webalorn [arobase@] gmail point com</a>
</p>
<script>
    $(function(){
        var mail = "webalorn";
        mail += "@";
        mail +="gmail";
        mail += ".";
        mail += "com";
        $("#mailWeba").attr("href", "mailto:"+mail);
        $("#mailWeba").text(mail);
    });
</script>

<?php
template_getFooter();

?>
