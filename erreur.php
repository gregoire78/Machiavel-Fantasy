<?php
//
// Created by Grégoire JONCOUR on 06/05/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
session_start();
session_regenerate_id();

//l'auto connexion
include_once('functions/functions_connect.php');
auto_connexion(NULL,NULL,NULL);

//fonctions
include_once('accessoires/menu.php');

if (isset($_GET['id'])) {
    switch ($_GET['id']) {
        case "401" :
            $imgError = "error401.svg";
            break;
        case "403" :
            $imgError = "error403.svg";
            break;
        case "404" :
            $imgError = "error404.svg";
            break;
        case "406" :
            $imgError = "error406.svg";
            break;
        case "500" :
            $imgError = "error500.svg";
            break;
        case "503" :
            $imgError = "error404.svg";
            break;
        default  :
            header("Loacation:index.php");
            break;
    }
} else {
    header("Loacation:index.php");
}

include_once("erreur.html");