<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */

if (isset($_GET['j'])) {
    switch ($_GET['j']) {
        case "edit_users" :
            include_once("utilisateurs/edit_users.php");
            break;
        case "edit_forum" :
            include_once("forums/edit_forum.php");
            break;
        case "maintenance" :
        include_once("maintenance.php");
        break;
        case "info_club" :
            include_once("club/info_club.php");
            break;
        case "liste_jeux" :
            include_once("liste_jeux/liste_jeux.php");
            break;
        case "fichiers_joints" :
            include_once("messages/fichiers_joints.php");
            break;
        case "fonction_forum" :
            include_once("general/fonction_forum.php");
            break;
        case "parametre_avatar" :
            include_once("general/parametre_avatar.php");
            break;
        case "parametre_mp" :
            include_once("messages/parametre_mp.php");
            break;
        case "parametre_messages" :
            include_once("messages/parametre_messages.php");
            break;
        case "parametre_signature" :
            include_once("general/parametre_signature.php");
            break;
        case "parametre_contact" :
            include_once("general/parametre_contact.php");
            break;
        case "parametre_email" :
            include_once("general/parametre_email.php");
            break;
        default  :
            include_once("general/accueil_general.php");
            break;
    }
} else
{
    include_once("general/accueil_general.php");
}
?>