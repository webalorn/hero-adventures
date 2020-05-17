<?php
    
    include_once($_SERVER["DOCUMENT_ROOT"].'/templates/aventures/template.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/aventures.php');
	include_once($_SERVER["DOCUMENT_ROOT"].'/aventures/afficherPage.php');

	function erreurHtml($html = "Une erreure est survenue.") {
		template_getHeader();
		echo $html;
		template_getFooter();
        exit;
	}
    
    if (!isset($_GET["id"]))
        erreurHtml('Erreur: no id');
    
    $idAdv = $_GET["id"];
    
    if (!isset($_SESSION))
        session_start();
    
    $userPseudo = "Anonyme";
    $userId = 0; $userCreateur = false;
    if (isset($_SESSION['id'])) {
        $userPseudo = $_SESSION['pseudo'];
        $userId = $_SESSION['id'];
    }
    
    $aventure = getInfosAventure($idAdv);
    if (!isset($aventure['id']))
        erreurHtml('Erreur: aventure inexistante');
	
	$userCreateur = ($userId == $aventure['userId']);
    if (!$aventure['activee'] && !$userCreateur)
        erreurHtml('Cette aventure n\'a pas encore etee activee par son proprietaire, ou a etee desactivee. Elle est par consequent inaccessible.');
	
	$partie = getPartieUser($idAdv, $userId);
    
    template_getHeader($aventure['nom'], $idAdv, $userCreateur);
    
	afficherPageAventure('introduction', $_GET["id"]);
	if (isset($_GET['pageDeb']) && $userCreateur) { ?>
	    <script>
	        $(function(){
	            loadPageAdv(<?php echo $_GET['pageDeb']; ?>);
	        });
	    </script>
	    <?php
	} else if (isset($_GET['pageDeb']))
	    echo '<div class="redAlert">Vous n\'etes pas l\'admin</div>';
    
    template_getFooter();
?>
