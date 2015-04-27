<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */
if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "edit_forum" :
            include_once("forums/edit_forum.php");
            break;
        case "delete_forum" :
            include_once("forums/delete_forum.php");
            break;
        case "restrict_forum" :
            include_once("forums/droits_forum.php");
            break;
        case "restrict_user" :
            include_once("forums/droits_users.php");
            break;
        default  :
            include_once("forums/edit_forum.php");
            break;
    }
} else {
    include_once("forums/edit_forum.php");
}
?>