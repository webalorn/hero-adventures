<?php

    function valider_pseudo(&$pseudo)
    {
        $pseudo = htmlspecialchars($pseudo);
        $longMin = 3; $longMax = 20;
        if (strlen($pseudo) > $longMax || strlen($pseudo) < $longMin)
            return false;
        return true;
    }
    
    function valider_password($pass)
    {
        $longMin = 6; $longMax = 20;
        if (strlen($pass) > $longMax || strlen($pass) < $longMin)
            return false;
        return true;
    }
    
    function valider_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


?>
