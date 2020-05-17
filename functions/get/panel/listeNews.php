<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

$nbAffiche = 5;
if (isset($_GET['nbAffiche']))
    $nbAffiche = $_GET['nbAffiche'];


$bdd = new Bdd();

$reqResult = $bdd->query("SELECT COUNT(*) AS compter FROM panel_news");
$donnees = $reqResult->fetch();
$nbEntrees = $donnees['compter'];

$limites = "";
if ($nbAffiche != "all")
{
    $nbEntrees = intval($nbEntrees);
    $fin = min($nbEntrees, $nbAffiche);
    //$reqResult = $bdd->query("SELECT * FROM panel_news ORDER BY \"id\" DESC LIMIT 0,".$fin);
    $limites = " LIMIT 0,".$fin;
}
$reqResult = $bdd->query("SELECT id, nom, texte, DATE_FORMAT(date, '%d/%m/%Y %Hh%i') AS date FROM panel_news ORDER BY id DESC".$limites);

while ($entree = $reqResult->fetch())
{
    //$date = new DateTime($entree['date']);
    //$entree['date'] = $date->format('d/m/Y \a H\Hi\m\i\n\u\t\e\s');
    ?>
    <div class="lienListeNews" data-texte="<?php echo $entree['texte']; ?>" data-date="<?php echo $entree['date']; ?>"><?php echo $entree['nom']; ?></div>
    <?php
}
?>

<style>
    .lienListeNews
    {
        font-size: 1.5em;
        color: #BD7B26;
        padding-bottom: 5px;
    }
    .lienListeNews:hover
    {
        color: #CC8529;
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<script>
    $(".lienListeNews").click(function(){
        //var date = new Date($(this).attr("data-date"));
        //var dateString = "Le "+date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear()+" a "+date.getHours()+"H"+date.getMinutes();
        var dateString = $(this).attr("data-date");
        newFenetre('<p style="font-style: italic">'+dateString+'</p><p>'+$(this).attr("data-texte")+'</p>', $(this).text());
    });
</script>
