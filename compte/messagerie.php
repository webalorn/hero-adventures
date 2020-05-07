<?php
    session_start();
    include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/messages.php');
    
    if (!isset($_SESSION['id'])) {
        header("Location: /site/connexion.php?deconnecte");
        exit;
    }

    template_getHeaderPart1("Messagerie");
?>
<style>
    #msgRecusPlus, #msgRecusLoad, #msgEnvoyesPlus, #msgEnvoyesLoad {
        text-align: center;
    }
    #msgRecusPlus, #msgEnvoyesPlus{
        display: none;
    }
    
    .msg_sujet {
        font-style: italic;
        display: inline-block;
        width: 35%;
        vertical-align: top;
    }
    .msg_user {
        font-weight: bold;
        display: inline-block;
        width: 30%;
        text-align: center;
        vertical-align: top;
    }
    .msg_date {
        font-style: italic;
        display: inline-block;
        width: 30%;
        text-align: right;
        vertical-align: top;
    }
    .msg_message {
        cursor: pointer;
        padding: 3px;
        position: relative;
    }
    .msg_message:hover {
        background-color: rgb(231, 231, 231);
    }
    .msg_message[data-lu="0"] {
        background-color: rgb(255, 234, 234);
    }
    .msg_message[data-lu="0"]:hover {
        background-color: rgb(255, 192, 192);
    }
    .msg_message[data-lu="0"]:hover:after {
        content: "non-lu";
        position: absolute;
        top: 0px;
        left: 100%;
        padding-left: 20px;
        display: block;
        height: 100%;
        width: 50px;
        background-color: rgb(255, 192, 192);
        line-height: 30px;
    }
    
    #messagerie_lecture .msg {
        margin-top: 20px;
        padding-left: 10px;
        border-left: 2px solid rgb(105, 105, 105);
        font-family: Courier New;
    }
    .bouttonsMsgSuite {
        margin-top: 20px;
    }
    
    /* liste membres recherche */
    
    #serchPseudoResult ul {
        padding: 0px;
        margin: 0px;
    }
    #serchPseudoResult li {
        cursor: pointer;
        list-style-type: none;
        padding: 4px;
        border-left: 2px solid #BFBFBF;
    }
    #serchPseudoResult li:hover {
        background: #BFBFBF;
    }
</style>
<?php
    template_getHeaderPart2();
?>
<h2>Messagerie</h2>

<?php
    if (isset($_POST['destinataire']) && isset($_POST['sujet']) && isset($_POST['contenu'])) {
        if (!$Messagerie->envoyer($_SESSION['id'], $_POST['destinataire'], $_POST['sujet'], $_POST['contenu'])) {
            echo '<div class="redAlert">Le destinataire n\'exite pas. Veuillez verifier le pseudo</div>';
        } else {
            echo '<div class="greenAlert">Message correctement envoye</div>';
            $_POST['destinataire'] = ""; $_POST['sujet'] = ""; $_POST['contenu'] = "";
        }
    }
    
    if (isset($_GET['user'])) {
        $_GET['user'] = $Messagerie->pseudoUser($_GET['user']);
        if ($_GET['user'] === null)
            unset($_GET['user']);
    }
?>

<div class="onglets">
    <ul>
        <li data-onglet="#messagerie_recus">Messages Recus</li>
        <li data-onglet="#messagerie_envoyes">Messages envoyes</li>
        <li data-onglet="#messagerie_new" id="ongletNew">Nouveau message</li>
        <li data-onglet="#messagerie_lecture" style="display: none;" id="lienLectureMsg">Lecture</li>
    </ul>
    
    <div id="messagerie_recus">
        <div id="msgRecus"></div>
        <div id="msgRecusPlus"><input type="button" value="Plus" /></div>
        <div id="msgRecusLoad"><img src="/templates/site/images/load.gif" alt="Loading..." /></div>
    </div>
    
    <div id="messagerie_envoyes">
        <div id="msgEnvoyes"></div>
        <div id="msgEnvoyesPlus"><input type="button" value="Plus" /></div>
        <div id="msgEnvoyesLoad"><img src="/templates/site/images/load.gif" alt="Loading..." /></div>
    </div>
    
    <div id="messagerie_lecture">
        Vous etes en train de lire un message
    </div>
    
    <div id="messagerie_new">
        <form method="POST" action="messagerie.php?onglet=new">
            <label>Destinataire: </label><br />
            <input id="pseudoNewMsg" type="text" value="<?php
                if (isset($_GET['user'])) 
                    echo $_GET['user'];
               else if (isset($_POST['destinataire']))
                    echo $_POST['destinataire'];
                ?>" name="destinataire" />
            <input type="button" value="rechercher" data-fen="#fenRecherchePseudo" />
            <br />
            <br />
            <label>Sujet: </label><br />
            <input id="sujetNewMsg" type="text" value="<?php if (isset($_POST['sujet'])) { echo $_POST['sujet']; } ?>" name="sujet" /><br />
            <br />
            <label>Message: </label><br />
            <textarea style="width: 90%; height: 200px;" name="contenu"><?php 
                if (isset($_POST['contenu'])) { echo $_POST['contenu']; }
            ?></textarea><br />
            <br />
            <input type="submit" value="Envoyer" />
        </form>
    </div>
</div>

<div id="fenRecherchePseudo">
    <h3>Rechercher un membre:</h3>
    <p>Ci dessous seront affiches tous les membres ayant dans leur pseudo la suite de caractere que vous taperez</p>
    <input type="text" placeholder="Votre recherche ici" id="serchPseudoInput" /><br />
    <input type="button" value="rechercher" id="buttSearchPseudo" />
    <br />
    <br />
    <div id="serchPseudoResult"></div>
</div>

<script>
    <?php
        if (isset($_GET['onglet']))
            echo 'var ongletDefaut = "#messagerie_'.$_GET['onglet'].'";';
       else
            echo 'var ongletDefaut = "#messagerie_recus";';
    ?>
    
    // messages
    var nbRecus = <?php echo $Messagerie->nbNonLus($_SESSION['id']); ?>;
    var nbEnvoyes = <?php echo $Messagerie->nbEnvoyes($_SESSION['id']); ?>;
    
    var recusNbAffiches = 0;
    var envoyesNbAffiches = 0;
    
    function liensMessages() {
        $(".msg_message[data-id]").each(function(){
            $(this).attr("data-idMsg", $(this).attr("data-id"));
            $(this).removeAttr("data-id");
            $(this).click(function(){
                $("#messagerie_lecture").html('<img src="/templates/site/images/load.gif" alt="Loading..." />');
                $("#lienLectureMsg").click();
                $("#messagerie_lecture").load("/functions/get/messageLire.php", {'id': $(this).attr("data-idMsg") });
                if ($(this).parent().attr("id") == "msgRecus" && $(this).attr("data-lu") == "0") {
                    $(this).attr("data-lu", "1");
                    var nb = parseInt($("#menuRondNbNonLus").text()) - 1;
                    $("#menuRondNbNonLus").text(nb);
                    if (nb <= 0)
                        $("#menuRondNbNonLus").remove();
                }
            });
        });
    }
    
    var nbAd = 10;
    
    function chargerMsgRecus() {
        $("#msgRecusPlus").css("display", "none");
        $("#msgRecusLoad").css("display", "block");
        $.post('/functions/get/messagesListe.php', { 'debut': recusNbAffiches, 'nb': nbAd, 'type': 'recus' }, function(data) {
            $(data).appendTo($("#msgRecus"));
            if (recusNbAffiches < nbRecus)
                $("#msgRecusPlus").css("display", "block");
            $("#msgRecusLoad").css("display", "none");
            liensMessages();
        });
        recusNbAffiches += nbAd;
    }
    function chargerMsgEnvoyes() {
        $("#msgEnvoyesPlus").css("display", "none");
        $("#msgEnvoyesLoad").css("display", "block");
        $.post('/functions/get/messagesListe.php', { 'debut': envoyesNbAffiches, 'nb': nbAd, 'type': 'envoyes' }, function(data) {
            $(data).appendTo($("#msgEnvoyes"));
            if (envoyesNbAffiches < nbEnvoyes)
                $("#msgEnvoyesPlus").css("display", "block");
            $("#msgEnvoyesLoad").css("display", "none");
            liensMessages();
        });
        envoyesNbAffiches += nbAd;
    }
    $(function(){
        chargerMsgRecus();
        chargerMsgEnvoyes();
        $("#msgRecusPlus input").click(chargerMsgRecus);
        $("#msgEnvoyesPlus input").click(chargerMsgEnvoyes);
    });
    
</script>

<script>
    // recherche de pseudos
    $(function(){
        $("#buttSearchPseudo").click(function(){
            $("#serchPseudoResult").text("Chargement...");
            $.post('/functions/get/membreSearch.php', { 'chaine': $("#serchPseudoInput").val()}, function(data) {
                var liste = $.parseJSON(data);
                var ul = $("<ul></ul>").appendTo($("#serchPseudoResult").html(""));
                for (var i in liste)
                    $("<li></li>").appendTo(ul).text(liste[i]).click(function(){
                        $(this).parents(".cacheBodyFen").css("display", "none");
                        $("#pseudoNewMsg").val($(this).text());
                    });
                if (liste.length == 0)
                    $("#serchPseudoResult").html("<span style='color: red;'>Aucun resultat</span>");
            });
        });
        $("#serchPseudoInput").keypress(function(e){
            if (e.keyCode == 13) // retour a la ligne
                $("#buttSearchPseudo").click();
        });
    });
</script>
<?php
    template_getFooter();
?>
