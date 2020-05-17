<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');

class MessagerieObjet {
    private $bdd;
    
    public function pseudoUser($id) {
        $req = $this->bdd->select("users", "WHERE id = :id", array("id" => $id));
        if (!$user = $req->fetch())
            return null;
        return $user['pseudo'];
    }
    
    public function __construct()
    {
        $this->bdd = new Bdd();
    }
    
    public function nbRecus($user) {
        $req = $this->bdd->query("SELECT COUNT(*) AS nbMsg FROM messages WHERE destinataire = ".intval($user));
        $req = $req->fetch();
        return $req['nbMsg'];
    }
    public function recus($user, $premier, $nbMsg) {
        return $this->bdd->query("SELECT * FROM messages WHERE destinataire = ".intval($user)." ORDER BY id DESC LIMIT ".intval($premier).",".intval($nbMsg));
    }
    public function nbNonLus($user) {
        $req = $this->bdd->query("SELECT COUNT(*) AS nbMsg FROM messages WHERE lu = 0 AND destinataire = ".intval($user));
        $req = $req->fetch();
        return $req['nbMsg'];
    }
    public function nbEnvoyes($user) {
        $req = $this->bdd->query("SELECT COUNT(*) AS nbMsg FROM messages WHERE emeteur = ".intval($user));
        $req = $req->fetch();
        return $req['nbMsg'];
    }
    public function envoyes($user, $premier, $nbMsg) {
        return $this->bdd->query("SELECT * FROM messages WHERE emeteur = ".intval($user)." ORDER BY id DESC LIMIT ".intval($premier).",".intval($nbMsg));
    }
    
    public function lireMsg($id, $userVerifie = null) {
        $req = $this->bdd->query("SELECT * FROM messages WHERE id = ".intval($id));
        if ($msg = $req->fetch()) {
            if ($userVerifie != null && $userVerifie != $msg['destinataire'] && $userVerifie != $msg['emeteur'])
                return null;
            if ($userVerifie == $msg['destinataire']) {
                $this->bdd->exec("UPDATE messages SET lu = 1 WHERE id = ".intval($id));
            }
            return $msg;
        }
        return null;
    }
    public function envoyer($emeteur, $destinataire, $sujet, $contenu) {
        $req = $this->bdd->select("users", "WHERE pseudo = :pseudo", array("pseudo" => $destinataire));
        if (!$desti = $req->fetch())
            return false;
        
        $this->bdd->insert("messages", array(
            "emeteur" => $emeteur,
            "destinataire" => $desti['id'],
            "sujet" => htmlspecialchars($sujet),
            "contenu" => htmlspecialchars($contenu),
            "date" => time()
        ));
        return true;
    }
    
}
$Messagerie = new MessagerieObjet();

?>
