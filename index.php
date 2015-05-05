<?php
session_start();
session_regenerate_id();

include_once('accessoires/functions_connect.php');
auto_connexion(NULL,NULL,NULL);
include_once('accessoires/menu.php');
//l'auto connexion

include_once("index.html");
?>