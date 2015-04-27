<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */
if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "1" :
            include_once("club/page_accueil.php");
            include_once("club/page_accueil.html");
            break;
        case "2" :
            include_once("club/info_club.php");
            include_once("club/info_club.html");
            break;
        case "3" :
            include_once("club/CGU.php");
            include_once("club/CGU.html");
            break;
        default  :
            include_once("club/page_accueil.php");
            include_once("club/page_accueil.html");
            break;
    }
} else {
    include_once("club/page_accueil.php");
    include_once("club/page_accueil.html");
}
?>