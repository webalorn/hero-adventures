<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

function afficherAccueilAide() {
    ?>
    <h2>Aide et tutoriels</h2>
    <p>
	    Ici, vous pourez trouver de l'aide pour l'utilisation de l'interface du site et le panneau de creation d'aventures. La partie "aventures" aidera sur le jeu, les regles, commencer jouer a une aventure. La partie "creation" vous aide sur le fonctionnement de l'interface de creation d'aventure, pour creer et editer vos propres histoires.
    </p>
    <p>
    Si, apres avoir cherche dans l'aide, vous avez encore un probleme que vous n'arrivez pas a resoudre, n'hesitez pas a me contacter, depuis <a href="/profil-1-admin">mon profil</a>, si vous etes inscrit sur le site.
    <?php
}

function afficherPageAide($nom) {
    if (!file_exists($nom))
        echo '<div class="redAlert">Cette page de l\'aide n\'existe pas ou plus!</div>';
    else
        echo file_get_contents($nom);
}

template_getHeaderPart1("Aide du site");
    echo '<link rel="stylesheet" href="/templates/site/css/menuAide.css" />';
template_getHeaderPart2();

include($_SERVER["DOCUMENT_ROOT"].'/templates/site/menuAide.php');
if (isset($_GET['page']))
    afficherPageAide($_GET['page']);
else
    afficherAccueilAide();

template_getFooter();

?>
