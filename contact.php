<?php
session_start();
session_regenerate_id();

include_once('accessoires/menu.php');
//l'auto connexion
auto_connexion(NULL,NULL,NULL);


include_once("contact.html");
?>