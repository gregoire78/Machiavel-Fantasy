<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */
if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "liste_jeux" :
            include_once("liste_jeux/liste_jeux.php");
            break;
        case "liste_type_jeux" :
            include_once("liste_jeux/liste_type_jeux.php");
            break;
        default  :
            include_once("liste_jeux/liste_jeux.php");
            break;
    }
} else {
    include_once("liste_jeux/liste_jeux.php");
}
?>