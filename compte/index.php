<?php
    session_start();
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/gererUser.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/reecriture-url.php');
    
    if (!isset($_SESSION['id'])) {
        header("Location: /site/connexion.php?deconnecte");
        exit;
    }

    template_getHeaderPart1("Votre Compte");
    
    $user = infosUser($_SESSION['id']);
    
?>
<style>
</style>
<?php
    template_getHeaderPart2();
    
    if (isset($_POST['pseudo']) && isset($_POST['avatar']) && isset($_POST['pass']) && isset($_POST['passConf']) && isset($_POST['email']) && isset($_POST['profil'])) {
        $infos = array(
            "pseudo" => $_POST['pseudo'],
            "pass" => $_POST['pass'],
            "passConf" => $_POST['passConf'],
            "avatar" => $_POST['avatar'],
            "email" => $_POST['email'],
            "profil" => $_POST['profil']
        );
        $retour = modifInfosUser($_SESSION['id'], $infos);
        if ($retour === true) {
            echo '<div class="greenAlert">Infos modifiee avec succes</div>';
            $user = infosUser($_SESSION['id']);
        }
        else {
            echo '<div class="redAlert">'.$retour.'</div>';
    
            if (isset($_POST['pseudo'])) $user['pseudo'] = $_POST['pseudo'];
            if (isset($_POST['email'])) $user['email'] = $_POST['email'];
            if (isset($_POST['profil'])) $user['profil'] = $_POST['profil'];
            if (isset($_POST['avatar'])) $user['avatar'] = $_POST['avatar'];
        }
    }

?>

<h2>Votre compte</h2>

<p>
    <input type="button" value="Voir mon profil"
    onclick="window.open('<?php echo urlRewiteProdil($_SESSION['pseudo'], $_SESSION['id']); ?>', '_self');" />
</p>

<form action="index.php" method="POST">
    <label for="pseudo">Pseudo: </label> <br />
    <input type="text" value="<?php echo $user['pseudo']; ?>" name="pseudo" /> <br />
    <br />
    <label for="pass">Mot de passe (vide pour ne pas changer):</label> <br />
    <input type="password" id="pass" name="pass" value="<?php if (isset($_POST['pass'])){ echo $_POST['pass']; }?>" /> <br />
    <br />
    <label for="passConf">Confirmation:</label> <br />
    <input type="password" id="passConf" name="passConf" value="<?php if (isset($_POST['passConf'])){ echo $_POST['passConf']; }?>" /> <br />
    <br />
    <label for="email">E-Mail:</label><br />
    <input type="email" value="<?php echo $user['email']; ?>" name="email" /> <br />
    <br />
    <label for="profilTxt">Texte de profil:</label><br />
    <textarea id="profilTxt" name="profil" style="min-width: 100%; max-width: 100%; min-height: 200px;"><?php echo $user['profil']; ?></textarea>
    <br />
    <label for="avatarUrlInput">Avatar (url de l'image, vide pour supprimer)</label><br />
    <input type="text" value="<?php echo $user['avatar']; ?>" name="avatar" id="avatarUrlInput" />
    <input type="button" value="Voir l'avatar" id="voirAvatar" style="margin-left: 20px;" />
    <input type="button" value="Upload" onclick="window.open('http://www.zupimages.net', '_blank');" style="margin-left: 20px;" /> <br />
    <img id="vueAvatar" src="" alt="Image inexistante" style="max-height: 120px; max-width: 120px;display: none;" />
    <p id="erreurAvatar"></p>
    <br />
    <input type="submit" value="Enregistrer" />
</form>
<script>
    function chargerAvatar() {
            var url = $("#avatarUrlInput").val().trim();
            if (!url) {
                $("#vueAvatar").css("display", "block").attr("src", "/templates/site/images/defaut_avatar.png");
                $("#erreurAvatar").html("");
            } else {
                if (url.indexOf("://") == -1)
                    url = "http://"+url;
                $("#erreurAvatar").text("Image en cours de chargement...");
                $("#vueAvatar").css("display", "none");
                
                var myImg = new Image();
                myImg.onload = function() {
                    $("#vueAvatar").css("display", "block").attr("src", url);
                    $("#erreurAvatar").html("");
                };
                myImg.onerror = function(){
                    $("#erreurAvatar").html("<span style='color:red;'>Cette image n'existe pas ou plus.</span>");
                };

                myImg.src = url;
            }
            $("#avatarUrlInput").val(url);
    }
    $(function(){
        $("#voirAvatar").click(chargerAvatar);
        chargerAvatar();
    });
</script>

<?php
    template_getFooter();
?>
