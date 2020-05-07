<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/adUser.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

template_getHeader("Inscription");

echo '<h2>Inscription</h2>';

    function inscriptionForm()
    {
    ?>
        <p class="alinea">
            S'inscrire a de nombreux aventages: vous avez avez access a vos parties partout, elles sont enregistrees sur le serveur. De plus, vous pouvez creer vos propres aventures, les diffuser et les envoyer par mail, sur les reseaux sociaux!
        </p>
        <form action="" method="POST" id="inscriptionForm">
            <div id="contForm">
                <p>
                    <label for="insPseudo">Pseudonyme : </label>
                    <input type="text" name="pseudo" id="insPseudo" placeholder="Pseudo ou nom" />
                </p>
                <p>
                    <label for="insMail">E-Mail : </label>
                    <input type="email" name="email" id="insMail" placeholder="Votre e-mail" /> <br />
                </p>
                <p>
                    <label for="insPass">Mot de passe : </label>
                    <input type="password" name="password" id="insPass" placeholder="Votre mot de passe" /> <br />
                </p>
                <p>
                    <label for="insPassConf">Confirmez le mot de passe : </label>
                    <input type="password" name="password_confirm" id="insPassConf" placeholder="Confirmation" /> <br />
                </p>
                <br />
                <input type="submit" value="Inscription" />
            </div>
        </form>
        <style>
            #contForm {
                display: inline-block;
            }
            #contForm input[name] {
                float: right;
                margin-left: 20px;
            }
            #contForm input[type=submit] {
                display: block;
                margin: auto;
            }
        </style>
        <script>
            $(function(){
                valideForm("#inscriptionForm", {
                    "pseudo": function(el){ return el.length >= 6; } ,
                    "email": "email" ,
                    "password": function(el){ return el.length >= 6; } ,
                    "password_confirm": function(el){ return el == $("#insPass").val(); }
                } , {
                    "pseudo": "Le pseudo doit avoir au moins 6 caracteres" ,
                    "email": "Mauvais e-mail: invalide" ,
                    "password": "Le mot de passe doit avoir au moins 6 caracteres" ,
                    "password_confirm": "Mauvaise confirmation du mot de passe"
                });
            });
        </script>
    <?php
    }
    
    function inscriptionError($message)
    {
        echo '<div class="redAlert">'.$message.'</div>';
        inscriptionForm();
    }
    
    function inscriptionSuccess()
    {
        echo '<p>Inscription reussie. Vous allez ecevoir un email pour confirmer votre inscription. Verifiez dans votre dossier SPAM si vous ne le trouvez pas au bout de quelques minutes.</p>';
    }

if ( isset($_POST["pseudo"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirm"]) )
{
    if ($_POST["password_confirm"] != $_POST["password"])
        inscriptionError('Vous vous etes trompe dans la confirmation du mot de passe');
    else
    {
        try
        {
            addUser($_POST["pseudo"], $_POST["email"], $_POST["password"]);
            inscriptionSuccess();
        }
        catch (AddUserException $e )
        {
            inscriptionError('Erreur dans les donnees: '.$e->getMessage());
        }
    }
}
else
    inscriptionForm();

template_getFooter();

?>
