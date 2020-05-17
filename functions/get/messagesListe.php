<?php
    session_start();
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/messages.php');
    
    if (isset($_POST['debut']) && isset($_POST['nb']) && isset($_POST['type']) && isset($_SESSION['id'])) {
        if ($_POST['type'] == "recus")
            $req = $Messagerie->recus($_SESSION['id'], $_POST['debut'], $_POST['nb']);
        else
            $req = $Messagerie->envoyes($_SESSION['id'], $_POST['debut'], $_POST['nb']);
        while ($msg = $req->fetch()) {
            $bdd = new Bdd();
            ?>
            <div class="msg_message" data-id="<?php echo $msg['id']; ?>" data-lu="<?php echo $msg['lu']; ?>">
                <span class="msg_sujet"><?php echo $msg['sujet']; ?></span>
                <span class="msg_user"><?php
                if ($_POST['type'] == "recus")
                    echo 'de '.$Messagerie->pseudoUser($msg['emeteur']);
                else
                    echo 'a '.$Messagerie->pseudoUser($msg['destinataire']);
                date_default_timezone_set('Europe/Berlin');
                ?></span>
                <span class="msg_date"><?php echo date("d/m/y H\hi", $msg['date']); ?></span>
            </div>
            <?php
        }
    }
    
?>
