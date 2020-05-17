<?php
    // This file is not the original file : I remove the passwords and other sensitive informations, and replaced them with "*********"

    function defaut_adminPass() { return "*********"; }
    
    function defaut_bdd_host() { return "localhost"; }
    function defaut_bdd_name() {
        if ($_SERVER['HTTP_HOST'] == "dev-loup-noir.000webhostapp.com" || $_SERVER['HTTP_HOST'] == "www.dev-loup-noir.000webhostapp.com") return "*********";
        return "*********";
    }
    function defaut_bdd_user(){
        if ($_SERVER['HTTP_HOST'] == "dev-loup-noir.000webhostapp.com" || $_SERVER['HTTP_HOST'] == "www.dev-loup-noir.000webhostapp.com") return "*********";
        return "*********";
    }
    function defaut_bdd_pass() { return defaut_adminPass(); }
    /* function defaut_bdd_host() { return "localhost"; }
    function defaut_bdd_name() { return "*********"; }
    function defaut_bdd_user() { return "*********"; }
    function defaut_bdd_pass() { return '*********'; } */
	
	//function defaut_url_jquery() { return '/jquery.js'; }
	function defaut_url_jquery() { return 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'; }

    function defaut_encrypt($pass)
    {
        $prefix1 = "*********"; $prefix2 = "*********";
        $suffix1 = "*********"; $suffix2 = "*********";
        return md5($prefix1 . sha1($prefix2 . $pass . $suffix2) . $suffix1);
    }
    
    function defaut_randomStr($taille = 20)
    {
        $str = "";
        $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSUTVWXYZ0123456789";
        $nb_chars = strlen($chaine);
        for($i = 0; $i < $taille; $i++)
        {
            $str .= $chaine[ rand(0, ($nb_chars-1)) ];
        }
        return $str;
    }
    
    function defaut_email_HTML($contenu) {
        return '<a href="http://loup-noir.000webhostapp.com/"><img src="http://loup-noir.000webhostapp.com/templates/site/images/logo.png" alt="Loup Noir" height="130px" /><h1>Le loup Noir</h1><h2>Les aventures dont vous etes le heros</h2></a><div style="padding: 15px;">'.$contenu.'</div><hr /><p>Loup Noir est un site permettant de jouer a des aventures dont vous etes le heros, et de creer les siennes. <a href="http://loup-noir.000webhostapp.com/">Voir le site</a> - <a href="http://loup-noir.000webhostapp.com/site/inscription.php">Inscription</a><p>';
    }

?>
