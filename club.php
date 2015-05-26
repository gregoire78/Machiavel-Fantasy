<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('functions/functions_connect.php');
auto_connexion(NULL,NULL,NULL);

include_once('accessoires/menu.php');

include_once("club.html");
?>