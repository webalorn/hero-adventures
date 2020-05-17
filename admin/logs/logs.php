<?php
    
    function printLog($fichier, $log)
    {
        $monfichier = fopen($_SERVER["DOCUMENT_ROOT"].'/admin/logs/'.$fichier, 'a');
        $date = new DateTime();
        $dateStr = $date->format('d/m/Y \a H\H i');
        fputs($monfichier, "--- LE ".$dateStr."\n");
        fputs($monfichier, $log);
    }
    
    function printLogSql($req)
    {
        printLog("sql.log", $req."\n");
    }
    
    function printLogSqlPrepare($req, $params)
    {
        $json = json_encode($params);
        printLogSql("requete preparee\n".$req."\n".$json);
    }
    
?>
