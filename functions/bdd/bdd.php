<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/admin/logs/logs.php');

class Bdd
{
    protected $bdd;
    
    public function prepare($chaine)
    {
        return $this->bdd->prepare($chaine);
    }
    
    public function __construct( $host = null , $name = null , $user = null , $pass = null )
    {
        if ($host == null) $host = defaut_bdd_host();
        if ($name == null) $name = defaut_bdd_name();
        if ($user == null) $user = defaut_bdd_user();
        if ($pass == null) $pass = defaut_bdd_pass();
        try
        {
	        $this->bdd = new PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
        }
        catch (Exception $erreur)
        {
            die('Erreur connexion Bdd : ' . $erreur->getMessage());
        }
    }
    
    public function select($table, $criteres, $remplace)
    {
        $preparation = "SELECT * FROM ".$table." ".$criteres;
        $req = $this->bdd->prepare($preparation);
        $req->execute($remplace);
        printLogSqlPrepare($preparation, $remplace);
        return $req;
    }
    
    public function insert($table, $params)
    {
        $chaine1 = ""; $chaine2 = "";
        $premier = true;
        foreach ($params as $cle => $elem)
        {
            if (!$premier)
            {
                $chaine1 .= ','; $chaine2 .= ',';
            }
            else
                $premier = false;
            $chaine1 .= $cle;
            $chaine2 .= ":".$cle;
        }
        $preparation = 'INSERT INTO '.$table.'('.$chaine1.') VALUES('.$chaine2.')';
        $req = $this->prepare($preparation);
        $req->execute($params);
        printLogSqlPrepare($preparation, $params);
    }
    
    public function update($table, $critere, $params)
    {
        $req = "UPDATE ".$table." SET ";
        $premier = true;
        foreach ($params as $cle => $val)
        {
            if (!$premier)
                $req .= ',';
            $premier = false;
            $req .= $cle." = :".$cle;
        }
        $req .= " ".$critere;
        $execution = $this->prepare($req);
        $execution->execute($params);
        printLogSqlPrepare($req, $params);
    }
    
    function exec($req)
    {
        printLogSql($req);
        return $this->bdd->exec($req);
    }
    
    function query($req)
    {
        printLogSql($req);
        return $this->bdd->query($req);
    }
    
    function get()
    { return $this->bdd; }
    
}

function bddFormateTab($tab) {
	foreach ($tab as $id => $val) {
		if (intval($id)."" == "".$id)
			unset($tab[$id]);
	}
	return $tab;
}

?>
