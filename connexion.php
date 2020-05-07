<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/connect.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

$conectAffiche = "form";

if ( isset($_POST["pseudo"]) && isset($_POST["password"]) )
{
    if (isset($_POST['retenir']))
        setcookie("pseudoConnect", $_POST["pseudo"], time()+36*36*24*365);
    $result = connexion($_POST["pseudo"], $_POST["password"]);
    if ($result == 'SUCCESS')
        $conectAffiche = "Succes";
    else
        $conectAffiche = "Error";
}
else
{
    if (isset($_SESSION['id']))
        $conectAffiche = "dejaConnect";
}


template_getHeader("Connexion");

if (isset($_GET['deconnecte']))
    echo '<div class="greenAlert">Vous avez ete deconnecte par le serveur</div>';

?><h2>Connexion</h2>
<?php
    if ($conectAffiche == "Succes")
        echo '<div class="greenAlert">Vous etes bien connecte</div>';
    
    if ($conectAffiche == "dejaConnect")
        echo '<div class="greenAlert">Vous etes deja connecte</div>';

    function connexionForm()
    {
        $pseudo = "";
        if (isset($_COOKIE['pseudoConnect']))
            $pseudo = $_COOKIE['pseudoConnect'];
    ?>
        <p>
            <a href="/site/inscription.php">Pas encore de compte?</a><br />
            <a href="/site/lostPassword.php">Mot de passe perdu?</a>
        </p>
        <form action="/site/connexion.php" method="POST">
            <label for="conectPseudo">Pseudonyme : </label> <br />
            <input type="text" name="pseudo" id="conectPseudo" value="<?php echo $pseudo; ?>" /> <br />
            
            <label for="conectPass">Mot de passe : </label> <br />
            <input type="password" name="password" id="conectPass" /> <br />
            <br />
            <input type="checkbox" name="retenir" /><label for="retenir">Retenir le login</label> <br />
            <br />
            <input type="submit" value="Connexion" />
        </form>
    <?php
    }
    
    if ($conectAffiche == "Error") {
        echo '<div class="redAlert">Erreur: verifiez votre identifiant/Mot de passe</div>';
        connexionForm();
    }
    if ($conectAffiche == "form")
        connexionForm();

template_getFooter();

?>
