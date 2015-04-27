<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */
if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "inactif_users" :
            include_once("utilisateurs/inactif_users.php");
            break;
        case "edit_users" :
            include_once("utilisateurs/edit_users.php");
            break;
        case "delete_users" :
            include_once("utilisateurs/delete_users.php");
            break;
        case "restrict_users" :
            include_once("utilisateurs/restrict_users.php");
            break;
        default  :
            include_once("utilisateurs/inactif_users.php");
            break;
    }
} else {
    include_once("utilisateurs/inactif_users.php");
}
?>