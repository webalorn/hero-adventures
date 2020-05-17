<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/templateAncien.php');

template_getHeader("Accueil");
?>

<h2>Accueil</h2>
<p class="alinea">
	Voici le site avant
</p>

<?php
template_getFooter();

?>