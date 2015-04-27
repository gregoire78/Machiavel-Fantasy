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
            include_once("forums/edit_forum.php");
            include_once("forums/edit_forum.html");
            break;
        case "2" :
            include_once("forums/delete_forum.php");
            include_once("forums/delete_forum.html");
            break;
        case "3" :
            include_once("forums/droits_forum.php");
            include_once("forums/droits_forum.html");
            break;
        case "4" :
            include_once("forums/droits_users.php");
            include_once("forums/droits_users.html");
            break;
        default  :
            include_once("forums/edit_forum.php");
            include_once("forums/edit_forum.html");
            break;
    }
} else {
    include_once("forums/edit_forum.php");
    include_once("forums/edit_forum.html");
}
?>