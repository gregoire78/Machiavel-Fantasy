<?php
session_start();
session_regenerate_id();

//fonctions
include_once('accessoires/menu.php');

//l'auto connexion
auto_connexion(NULL,NULL,0);

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