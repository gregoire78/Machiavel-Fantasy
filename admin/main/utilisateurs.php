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
            include_once("utilisateurs/inactif_users.php");
            include_once("utilisateurs/inactif_users.html");
            break;
        case "2" :
            include_once("utilisateurs/edit_users.php");
            include_once("utilisateurs/edit_users.html");
            break;
        case "3" :
            include_once("utilisateurs/delete_users.php");
            include_once("utilisateurs/delete_users.html");
            break;
        case "4" :
            include_once("utilisateurs/restrict_users.php");
            include_once("utilisateurs/restrict_users.html");
            break;
        default  :
            include_once("utilisateurs/inactif_users.php");
            include_once("utilisateurs/inactif_users.html");
            break;
    }
} else {
    include_once("utilisateurs/inactif_users.php");
    include_once("utilisateurs/inactif_users.html");
}
?>