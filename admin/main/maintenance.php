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
            $text = 1;
            break;
        case "2" :
            $text = 2;
            break;
        case "3" :
            $text = 3;
            break;
        case "4" :
            $text = 4;
            break;
        case "5" :
            $text = 5;
            break;
        case "6" :
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