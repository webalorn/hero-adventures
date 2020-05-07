<?php
    session_start();
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/user/gererUser.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/reecriture-url.php');
    
    $infos = false;
    $pseudo = "utilisateur inexistant";
    
    if (isset($_GET['id']) && $infos = infosUser($_GET['id'])) {
        $pseudo = htmlspecialchars($infos['pseudo']);
    }
    
    function profilToHtml($profil) {
        $profil = nl2br(htmlspecialchars($profil));
        
        return $profil;
    }

    template_getHeaderPart1("Profil - ".$pseudo);
    
?>
<style>
    #profil header img {
        max-width: 120px;
        max-height: 120px;
        display: inline-block;
        vertical-align: middle;
    }
    #profil header h2 {
        display: inline-block;
        margin-left: 30px;
        vertical-align: middle;
    }
    #profil header div {
        margin-top: 20px;
        margin-left: 15px;
        font-weight: bold;
    }
    #profil header {
        margin-bottom: 40px;
    }
    #profil footer {
        margin-top: 40px;
    }
    
    #listeAdvsUser li a:hover:after {
        content: " - Voir";
        color: rgb(87, 87, 87);
    }
    #listeAdvsUser li a:hover {
        background-color: rgba(179, 179, 179, 1);
    }
    #listeAdvsUser li a {
        text-decoration: none;
        display: block;
        padding: 5px;
    }
    #listeAdvsUser li {
        list-style-type: none;
    }
    
    #profilTxt {
        border-left: 2px solid rgb(150, 150, 150);
        padding-left: 15px;
    }
</style>
<?php
    template_getHeaderPart2();
    
    if ($infos)
    {
    ?>
    <div id="profil">
        <header>
            <img src="<?php if ($infos['avatar']) { echo $infos['avatar']; } else { echo '/templates/site/images/defaut_avatar.png'; } ?>" alt="" />
            <h2>Profil de <?php echo $pseudo; ?></h2>
            <div>
                <?php $format = "d/m/Y \a H\hi"; ?>
                <span>Inscrit le: <?php echo date($format, $infos['dateInscrit']); ?></span><br/>
                <!--<span>Derniere connexion le: <?php echo date($format, $infos['dateActif']); ?></span><br />-->
            </div>
        </header>
        <section id="profilTxt">
            <?php echo profilToHtml($infos['profil']); ?>
        </section>
        <section id="listeAdvsUser">
        <?php
            $advs = listeAventuresUser($infos['id'], true);
            if (count($advs) > 0) {
                    echo '<h3>Liste des aventures activees crees par '.$pseudo.'</h3><ul>';
                foreach ($advs as $adv) {
                    echo '<li><a href="'.urlRewiteAventure($adv['nom'], $adv['id']).'">'.$adv['nom'].'</a></li>';
                }
                echo '</ul>';
            } else {
                echo '<br /><em>Cette utilisateur n\'a aucune aventure activee</em>';
            }
        ?>
        </section>
        <footer>
            <?php
                if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) { ?>
                    <input type="button" value="Editer mon profil" onclick="window.open('/site/compte/', '_self');" />
                <?php } else if (isset($_SESSION['id'])) { ?>
                    <input type="button" value="Envoyer un message"
                    onclick="window.open('/site/compte/messagerie.php?onglet=new&user=<?php echo $_GET['id']; ?>', '_self');" />
                <?php } else {?>
                    <em>Pour contacter l'utilisateur, vous devez etre inscrit et connecte</em>
                <?php } ?>
        </footer>
    </div>
    <?php
    }
    else
        echo '<h3>Cette utilisateur n\'existe pas ou plus</h3>';
    
    template_getFooter();
?>
