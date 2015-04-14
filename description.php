<?php
session_start();
session_regenerate_id();

include_once('accessoires/menu.php');
//l'auto connexion
auto_connexion(NULL,NULL,NULL);

//On récupère toutes les données du type de jeu (./accessoires/functions_jeu.php)
$query = recup_type_jeu();
$i=0;
while ($data=$query->fetch(PDO::FETCH_ASSOC)){
	$id_type_jeu[$i]= $data['id_type_jeu'];
	$libelle_type_jeu[$i]= $data['libelle_type_jeu'];
	$image_type_jeu[$i]=$data['image_type_jeu'];
	$description_type_jeu[$i]=substr($data['description_type_jeu'],0,150)." ...";
	$i++;
}
include_once("description.html");
?>