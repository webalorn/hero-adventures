<?php

session_start();

if (!isset($_SESSION['id']))
{
    echo '-1';
    exit;
}

?>
