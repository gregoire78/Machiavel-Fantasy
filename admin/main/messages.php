<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */
if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "parametre_mp" :
            include_once("messages/parametre_mp.php");
            break;
        case "parametre_messages" :
            include_once("messages/parametre_messages.php");
            break;
        case "icon_topic" :
            include_once("messages/icon_topic.php");
            break;
        case "smiley" :
            include_once("messages/smiley.php");
            break;
        case "fichiers_joints" :
            include_once("messages/fichiers_joints.php");
            break;
        case "edit_fichiers_joints" :
            include_once("messages/edit_fichiers_joints.php");
            break;
        default  :
            include_once("messages/parametre_mp.php");
            break;
    }
} else {
    include_once("messages/parametre_mp.php");
}
?>