<?php
session_start();
include_once("accessoires/menu.php");

$id_jeu=$_GET['jeu'];
$query = recup_jeu($id_jeu);

//On parcourt les données du jeu
$data=$query->fetch(PDO::FETCH_ASSOC);
$title_jeu=$data['title_jeu'];
$text_jeu=nl2br($data['text_jeu']);
$date_update=format_date($data['date_update']);

include_once("complete_jeu.html");
?>