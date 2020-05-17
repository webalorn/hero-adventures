<?php
    
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
    
    if (!isset($_SESSION))
        session_start();
    if (!isset($_SESSION['aventureId']) || !isset($_SESSION['aventureName']))
    {
        echo 'ERREUR: aucune aventure choisie';
        exit;
    }
    
?>
<script>
    $("#aventureMenu").css("display", "block");
    isActuAventure = true;
</script>
