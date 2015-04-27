<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */
if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "accueil" :
            include_once("club/page_accueil.php");
            break;
        case "info" :
            include_once("club/info_club.php");
            break;
        case "CGU" :
            include_once("club/CGU.php");
            break;
        default  :
            include_once("club/page_accueil.php");
            break;
    }
} else {
    include_once("club/page_accueil.php");
}
?>