<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/functions/valider.php');
    
    function infosUser($id) {
        $bdd = new Bdd();
        $req = $bdd->select("users", "WHERE id = :id", array("id" => $id));
        return $req->fetch();
    }
    
    function modifInfosUser($id, $infos) {
        if (!$infos['pass']) {
            unset($infos['pass']);
            unset($infos['passConf']);
        } else {
            if (!valider_password($infos['pass']))
                return "Le mot de passe doit faire de 6 a 20 caracteres";
            if ($infos['pass'] != $infos['passConf'])
                return "Mauvaise confimation du mot de passe";
        }
        if (!valider_pseudo($infos['pseudo']))
            return "Le pseudo doit faire de 3 a 20 caracteres";
        if (!valider_email($infos['email']))
            return "E-Mail incorect";
        $infos['avatar'] = trim($infos['avatar']);
        if ($infos['avatar'] && stripos($infos['avatar'], '://') === false)
            $infos['avatar'] = 'http://'.$infos['avatar'];
        setInfosUser($id, $infos);
        return true;
    }
    
    function setInfosUser($id, $infos) {
        $bdd = new Bdd();
        $req = $bdd->update("users", "WHERE id = ".intval($id), $infos);
    }
    
    function listeAventuresUser($id, $actives = false) {
        $bdd = new Bdd();
        $req = $bdd->select("aventures", "WHERE userId = :id", array("id" => $id));
        $array = array();
        while ($adv = $req->fetch())
            if ($adv['activee'] || !$actives)
                $array[] = $adv;
        return $array;
    }
    
?>
