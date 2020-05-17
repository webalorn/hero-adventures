<?php

function urlRewiteAventure($nomAventure, $id) {
    $url = "/aventure-".$id."-";
    $adTiret = false;
    $nomAventure = str_split($nomAventure);
    foreach ($nomAventure as $id => $car) {
        if (!preg_match("#[a-zA-Z0-9]#", "".$car)) {
            if ($adTiret) {
                $adTiret = false;
                $url .= "-";
            }
        } else {
            $adTiret = true;
            $url .= $car;
        }
    }
    if (!$adTiret)
        $url = substr($url, 0, strlen($url)-1);
    return $url;
}

function urlRewiteProdil($pseudo, $id) {
    $url = "/profil-".$id."-";
    $adTiret = false;
    $pseudo = str_split($pseudo);
    foreach ($pseudo as $id => $car) {
        if (!preg_match("#[a-zA-Z0-9]#", "".$car)) {
            if ($adTiret) {
                $adTiret = false;
                $url .= "-";
            }
        } else {
            $adTiret = true;
            $url .= $car;
        }
    }
    if (!$adTiret)
        $url = substr($url, 0, strlen($url)-1);
    return $url;
}

?>
