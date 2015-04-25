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
            include_once("utilisateurs/edit_users.php");
            include_once("utilisateurs/edit_users.html");
            break;
        case "2" :
            include_once("forums/edit_forum.php");
            include_once("forums/edit_forum.html");
            break;
        case "4" :
            include_once("club/info_club.php");
            include_once("club/info_club.html");
            break;
        case "5" :
            include_once("liste_jeux/liste_jeux.php");
            include_once("liste_jeux/liste_jeux.html");
            break;
        case "6" :
            include_once("messages/fichiers_joints.php");
            include_once("messages/fichiers_joints.html");
            break;
        case "7" :
            include_once("general/fonction_forum.php");
            include_once("general/fonction_forum.html");
            break;
        case "8" :
            include_once("general/parametre_avatar.php");
            include_once("general/parametre_avatar.html");
            break;
        case "9" :
            include_once("messages/parametre_mp.php");
            include_once("messages/parametre_mp.html");
            break;
        case "10" :
            include_once("messages/parametre_messages.php");
            include_once("messages/parametre_messages.html");
            break;
        case "11" :
            include_once("general/parametre_signature.php");
            include_once("general/parametre_signature.html");
            break;
        case "12" :
            include_once("general/parametre_contact.php");
            include_once("general/parametre_contact.html");
            break;
        case "13" :
            include_once("general/parametre_email.php");
            include_once("general/parametre_email.html");
            break;
        default  :
            include_once("utilisateurs/edit_users.php");
            include_once("utilisateurs/edit_users.html");
            break;
    }
} else {
    include_once("utilisateurs/edit_users.php");
    include_once("utilisateurs/edit_users.html");
}
?>