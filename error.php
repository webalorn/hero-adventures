<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/templates/site/template.php');

template_getHeader();

if (!isset($_GET['error']))
    $_GET['error'] = 404;

?>
<h2>Erreur <?php echo $_GET['error']; ?> </h2>
<p>
    <?php
        switch (intval($_GET['error']))
        {
            case 404:
                echo 'Cette page n\'existe pas ou plus';
                break;
            default:
                echo '';
        }
    ?>
</p>
<?php

template_getFooter();

?>
