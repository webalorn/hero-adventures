<?php

session_start();

include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

template_getHeader("Conditions d'utilisation");
?>

<h2>Conditions d'utilisation du site Loup Noir</h2>
<p class="alinea">
	Aucune reproduction partielle ou totale du site et de son contenu, que ce soit images, design ou texte, n'est acceptee sans autorisation expresse.
</p>
<p class="alinea">
	Il est strictement interdit de se servir du site pour mettre en ligne des propos, images, documents ou autres etants interdits par la loi francaise ou de votre pays.
	Il est interdit de mentire sur son identitee, de tenter de modifier le site ou d'en prendre le control, de prendre le control d'un compte d'un autre utilisateur.
</p>
<p class="alinea">
	En cas de non-respect de ces conditions, de mise en ligne de contenu illegal, le site et son webmaster ne sont en aucun cas tenu comme responssable de ces actes.
	Tout contenu ne respectant pas les regles sera supprime. Si vous en trouvez, veuillez contacter le <a href="/site/webmaster.php">webmaster</a></p>.
</p>

<?php
template_getFooter();

?>