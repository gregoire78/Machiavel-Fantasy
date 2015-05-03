<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 15:00
 */
ob_start();
session_start();

session_regenerate_id();

include_once('../accessoires/functions_connect.php');
//l'auto connexion
auto_connexion(NULL,'../index.php',3);
include_once("index.html");
ob_end_flush();
?>