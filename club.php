<?php
session_start();
include_once("accessoires/menu.php");
include_once("accessoires/connect_bdd.php");
include_once("accessoires/auto_connexion.php");
include_once("accessoires/functions_connect.php");
$droits = verif_droit();

if(isset($_GET['modifier'])){
	$club=1;
}
//On récupère les données du club
$sql="SELECT text_club, date_update FROM club;";
$query=$connect->prepare($sql);
$query->execute();

$data=$query->fetch(PDO::FETCH_ASSOC);
$text_club=$data['text_club'];
$date_update=$data['date_update'];

include_once("club.html");
?>