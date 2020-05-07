<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/connect.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/E-mail.php');

template_getHeader("Recuperer le mot de passe");
?>
<h2>Recuperation de mot de passe</h2>
<p>
    <a href="/site/connexion.php">Page de connexion</a><br />
</p>
<?php
    function recupereForm()
    {
    ?>
        <form action="/site/lostPassword.php" method="POST">
            <p>
                Pour reinitialiser votre mot de passe, vous devez entrer votre pseudo et votre e-mail. Vous pourrez alors changez votre mot de passe grace au lien envoye par  mail.
            </p>
            <label for="resetPseudo">Pseudonyme : </label> <br />
            <input type="text" name="pseudo" id="resetPseudo" value="<?php if (isset($_POST['pseudo'])){ echo $_POST['pseudo']; } ?>" /> <br />
            
            <label for="resetMail">Email : </label> <br />
            <input type="email" name="email" id="resetMail" value="<?php if (isset($_POST['email'])){ echo $_POST['email']; } ?>"  /> <br />
            <br />
            <input type="submit" value="Envoyer" />
        </form>
    <?php
    }
    $bdd = new Bdd();
    if (isset($_POST['pseudo']) && isset($_POST['email']))
    {
        $pass = defaut_randomStr();
        
        $req = $bdd->prepare("SELECT id FROM users WHERE pseudo = :pseudo AND email = :mail");
        $req->execute(array("pseudo" => $_POST['pseudo'], "mail" => $_POST['email']));
        if (!$req->fetch()) {
            echo '<div class="redAlert">Erreur: il n\'y a aucun compte avec cette paire pseudo/email. Veuillez verifier les informations</div>';
            recupereForm();
        }
        $req = $bdd->prepare("UPDATE users SET passReset = :pass WHERE pseudo = :pseudo AND email = :mail");
        $req->execute(array("pseudo" => $_POST['pseudo'], "mail" => $_POST['email'], "pass" => defaut_encrypt($pass)));
        
        $emailObj = new Email("admin@loup-noir.000webhostapp.com", $_POST['email']);
        $emailObj->setSubject("Reinitialisation du mot de passe sur Loup Noir");
        $emailObj->setContent(
'<p>Vous avez demande a reinitialiser votre mot de passe. Vous pouvez maintenant vous connecter avec ce mot de passe: <strong>'.$pass.'</strong> sur votre compte <strong>'.$_POST['pseudo'].'</strong><br />
Pensez a changer ensuite votre mot de passe!</p>
<p>Si vous n\'etes pas a l\'origine de cette demande, vous pouvez continuer a vous connecter normallement, avec votre ancien mot de passe</p>'
        );
        $emailObj->send();
        
        echo '<div class="greenAlert">Vous avez recu votre nouveau mot de passe par e-mail. Verifiez dans votre dossier SPAM si vous ne le trouvez pas au bout de quelques minutes.</div>';
    }
    else
        recupereForm();

template_getFooter();

?>
