<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 15:00
 */
session_start();
if(isset($_GET['i'])) {
    switch ($_GET['i']) {
        case "1" :
            include_once("main/general.php");
            break;
        case "2" :
            include_once("main/club.php");
            break;
        case "3" :
            include_once("main/forums.php");
            break;
        case "4" :
            include_once("main/messages.php");
            break;
        case "5" :
            include_once("main/utilisateurs.php");
            break;
        case "6" :
            include_once("main/historique.php");
            break;
        case "7" :
            include_once("main/liste_jeux.php");
            break;
        default  :
            include_once("main/general.php");
            break;
    }
}
else
{
    include_once("main/general.php");
}
include_once("index.html");
?>