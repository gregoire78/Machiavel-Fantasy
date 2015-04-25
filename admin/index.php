<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 15:00
 */
session_start();
if(!isset($_SESSION['id_user']) || $_SESSION['droits']< 3)
{
    header("Location:../");
}
include_once("index.html");

?>