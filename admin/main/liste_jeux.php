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
            include_once("liste_jeux/liste_jeux.php");
            include_once("liste_jeux/liste_jeux.html");
            break;
        case "2" :
            include_once("liste_jeux/liste_type_jeux.php");
            include_once("liste_jeux/liste_type_jeux.html");
            break;
        default  :
            include_once("liste_jeux/liste_jeux.php");
            include_once("liste_jeux/liste_jeux.html");
            break;
    }
} else {
    include_once("liste_jeux/liste_jeux.php");
    include_once("liste_jeux/liste_jeux.html");
}
?>