<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */

if (isset($_GET['m'])) {
    switch ($_GET['m']) {
        case "global" :
            $text = 1;
            break;
        case "administration" :
            $text = 2;
            break;
        case "jeu" :
            $text = 3;
            break;
        case "forum" :
            $text = 4;
            break;
        case "evenement" :
            $text = 5;
            break;
        case "utilisateur" :
            $text = 6;
            break;
        default  :
            $text = 1;
            break;
    }
} else {
    $text = 1;
}
include_once("maintenance.html");
?>