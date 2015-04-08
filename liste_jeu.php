<?php
session_start();
include_once("accessoires/menu.php");
$id_type_jeu=$_GET['jeu'];

//On récupère les informations concernant le type de jeu	(.accessoires/functions_jeu.php)
$query = recup_type_jeu_one($id_type_jeu);
$data=$query->fetch(PDO::FETCH_ASSOC);
$libelle_type_jeu = $data['libelle_type_jeu'];
$description_type_jeu = $data['description_type_jeu'];

//On récupère la liste des jeux en base de donnée			(.accessoires/functions_jeu.php)
$query=recup_liste_jeu($id_type_jeu);
$j=0;
//On parcourt les jeux de la base de donnée
while ($data=$query->fetch(PDO::FETCH_ASSOC)){
	$id_jeu[$j]= $data['id_jeu'];
	$title_jeu[$j]=$data['title_jeu'];
	$image_jeu[$j]=$data['image_jeu'];
	$text_jeu[$j]=strip_tags(substr(($data['text_jeu']),0,300))." ...";
	$date_update[$j]=date("d/m/Y",strtotime ($data['date_update']));
	$j++;
}
include_once("liste_jeu.html");

?>