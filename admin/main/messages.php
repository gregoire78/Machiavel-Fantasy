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
            include_once("messages/parametre_mp.php");
            include_once("messages/parametre_mp.html");
            break;
        case "2" :
            include_once("messages/parametre_messages.php");
            include_once("messages/parametre_messages.html");
            break;
        case "3" :
            include_once("messages/icon_topic.php");
            include_once("messages/icon_topic.html");
            break;
        case "4" :
            include_once("messages/smiley.php");
            include_once("messages/smiley.html");
            break;
        case "5" :
            include_once("messages/fichiers_joints.php");
            include_once("messages/fichiers_joints.html");
            break;
        case "6" :
            include_once("messages/edit_fichiers_joints.php");
            include_once("messages/edit_fichiers_joints.html");
            break;
        default  :
            include_once("messages/parametre_mp.php");
            include_once("messages/parametre_mp.html");
            break;
    }
} else {
    include_once("messages/parametre_mp.php");
    include_once("messages/parametre_mp.html");
}
?>