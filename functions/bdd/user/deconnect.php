<?php
    session_start();
    //if (isset($_SESSION['id']))
    //    unset($_SESSION['id']);
    session_destroy();
    unset($_SESSION);
    header("Location: /");
?>
