<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

function genererArboAventure($aventure)
{
    $aventure = intval($aventure);
    $bdd = new Bdd();
    $dossiers = array();
    
    $modeleDir = array(
        'pages' => array(),
        'dossiers' => array(),
        'parent' => null,
        'nom' => "racine",
        'etat' => 0,
        'id' => null
    );
    
    $dossiers['racine'] = $modeleDir;
    
    $result = $bdd->query("SELECT * FROM dossiers WHERE aventure = ".$aventure);
    while ($dir = $result->fetch())
    {
        $dirObj =  $modeleDir;
        $dirObj['parent'] = $dir['parent'];
        $dirObj['nom'] = $dir['nom'];
        $dirObj['id'] = $dir['id'];
        $dossiers[$dir['id']] = $dirObj;
    }
    
    $result = $bdd->query("SELECT id,nom,dossierId FROM pages WHERE aventure = ".$aventure);
    while ($page = $result->fetch())
    {
        if (!array_key_exists($page['dossierId'], $dossiers))
            $page['dossierId'] = 'racine';
        $pageTab = array();
        foreach ($page as $id => $cont)
        {
            $id2 = intval($id);
            if (''.$id2 != ''.$id)
                $pageTab[$id] = $page[$id];
        }
        array_push($dossiers[$page['dossierId']]['pages'], $pageTab);
    }
    
    $DFS1 = function ($id) use (&$DFS1, &$dossiers) // permet de verfifier et former l'integraliste de l'arbre de l'arborescence
    {
        if ($id == 'racine' || !array_key_exists($id, $dossiers))
            return 'racine';
        
        if ($dossiers[$id]['etat'] == 2)
            return $id;
        if ($dossiers[$id]['etat'] == 1)
            return 'racine';
        $dossiers[$id]['etat'] = 1;
        
        $dossiers[$id]['parent'] = $DFS1($dossiers[$id]['parent']);
        
        $dossiers[$id]['etat'] = 2;
        return $id;
    };
    foreach ($dossiers as $id => $dir)
        $DFS1($id);
        
    foreach ($dossiers as $id => $dir)
    {
        unset($dossiers[$id]['etat']);
		if (isset($dir['parent']))
			$dossiers[$dir['parent']]['dossiers'][] = $id;
    }
    
    //trier
    $compDirsId = function ($i1, $i2) use (&$dossiers)
    {
        $nom1 = $dossiers[$i1]['nom'];
        $nom2 = $dossiers[$i2]['nom'];
        if ($nom1 < $nom2)
            return -1;
        if ($nom1 == $nom2)
            return 0;
        return 1;
    };
    $compFiles = function ($f1, $f2) use (&$dossiers)
    {
        $nom1 = $f1['nom'];
        $nom2 = $f2['nom'];
        if ($nom1 < $nom2)
            return -1;
        if ($nom1 == $nom2)
            return 0;
        return 1;
    };
    foreach ($dossiers as $id => $dir)
    {
        if (!$id)
            unset($dossiers[$id]);
        else
        {
            usort($dossiers[$id]['dossiers'], $compDirsId);
            usort($dossiers[$id]["pages"], $compFiles);
        }
    }
    
    $DFS2 = function (&$dir) use (&$DFS2, &$dossiers) // "fabriquer" l'arborescence
    {
        foreach ($dir['dossiers'] as $cle => $id)
        {
            $dir['dossiers'][$cle] = $dossiers[$id];
            $DFS2($dir['dossiers'][$cle]);
        }
    };
    $racine = $dossiers['racine'];
    $DFS2($racine);
    
    return $racine;
}

if (isset($_POST['arboIdAventure']))
    echo JSON_encode(genererArboAventure($_POST['arboIdAventure']));

?>
