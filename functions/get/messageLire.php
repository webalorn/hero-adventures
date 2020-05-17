<?php
    session_start();
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/messages.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/reecriture-url.php');

    if (isset($_POST['id']) && isset($_SESSION['id'])) {
        $msg = $Messagerie->lireMsg($_POST['id'], $_SESSION['id']);
        if ($msg != null) {
            date_default_timezone_set('Europe/Berlin');
            if ($msg['emeteur'] == $_SESSION['id']) {
                $prefix = "a ";
                $autreName = $Messagerie->pseudoUser($msg['destinataire']);
                $autreId = $msg['destinataire'];
            } else {
                $prefix = "de ";
                $autreName = $Messagerie->pseudoUser($msg['emeteur']);
                $autreId = $msg['emeteur'];
            }
            ?>
            <h3><?php echo $msg['sujet']; ?></h3>
            <div class="auteurMsg"><?php echo $prefix, $autreName; ?></div>
            <div class="dateMsg">le <?php echo date("d/m/y H\hi", $msg['date']); ?></div>
            <div class="msg"><?php echo nl2br($msg['contenu']); ?></div>
            <div class="bouttonsMsgSuite">
                <input type="button" value="Profil"
                onclick="window.open('<?php echo str_replace('"', '\"', urlRewiteProdil($autreName, $autreId)); ?>', '_self');" />
                <input type="button" value="Repondre" onclick="$('#pseudoNewMsg').val('<?php
                    echo str_replace('\'', '\\\'', str_replace('"', '\"', $autreName));
                ?>');$('#sujetNewMsg').val('<?php
                    echo str_replace('\'', '\\\'', str_replace('"', '\"', 're:'.$msg['sujet']));
                ?>'); $('#ongletNew').click();" />
            </div>
            <?php
        }
    }

?>
