<?php

if (!isset($_SESSION))
	session_start();

if (!isset($_SESSION['id']))
{
    echo '-1';
    exit;
}

?>
