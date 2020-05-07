<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

template_getHeaderPart1("Accueil");
?>
<style>
    #presentationTab {
        border-collapse: collapse;
    }
    #presentationTab td
    {
        background: rgba(255, 255, 255, 0.1);background: rgba(255, 255, 255, 0.1);
        padding: 10px;
        width: 50%;
        border: 3px solid black;
    }
</style>
<?php template_getHeaderPart2(); ?>
<div class="greenAlert">
    <p>
        Le site fut simplement un essai de code. il est fonctionnel, mais aucune fonction ne sera ajoutee, aucun bug ne sera regle. Si vous desirez utiliser un site de ce type, n'utilisez pas celui-ci !
    </p>
</div>


<p class="alinea">
    Une <strong>aventure dont vous etes le heros</strong>? He bien, c'est comme un roman, une histoire, dans n'importe quel univers, mais ou le personage principal, c'est <strong>Vous</strong>! A chaques etapes, vous choisissez la destinee du heros. Ce type de jeu, proche des jeux de roles, et ayant connu un succes dans les livres-jeux, est disponible ici, en ligne, gratuitement.
</p>
<p class="alinea">
    Vous avez la possibilitee, sans inscription, de jouer toutes les aventures sur le site et de les enregistrer sur votre navigateur. L'inscription, gratuite, vous permet de creer vos <strong>propres</strong> aventures et de les diffuser. Vous pourrez egallement enregistrer toutes vos parties en ligne, pour y acceder depuis n'importe quel machine!
</p>
<p style="font-style: italic;">
    Le site est encore en cours de devellopement. Les fonctionalitee ne sont pas encore toutes presentes, mais de nouvelles arriveront au fur et a mesure. Cependant, les fonctions essentielles, creations de pages et d'aventures, sont déjà présentes.
</p>
<?php if (!isset($_SESSION['id'])) { ?>
<p style="text-align: center;">
    <input type="button" value="S'inscrire tout de suite!" onclick="window.open('/site/inscription.php', '_parent');" />
</p>
<?php } ?>
<!--<table id="presentationTab">
   <tr>
       <td><h4>Simple: </h4>Un panneau de cration leger, epure, fonctionnel, des aventures courtes ou longues, gere simplement par le site.</td>
       <td><h4>Bientot complet: </h4>De nombreuses fonctionnalitees en devellopement: inventaires, combats, pieges, dialogues...</td>
   </tr>
   <tr>
       <td><h4>Gratuit: </h4>Le site est integrallement gratuit: Vous avez un access illimite a toutes les fonctionnalitee sans depenser un seul centime!</td>
       <td><h4>Inovations: </h4>Le site cherche a innover, grandir, s'ameliorer. Il est constamment remis en cause pour une meilleure experience utilisateur</td>
   </tr>
</table>-->

<?php
template_getFooter();

?>
		