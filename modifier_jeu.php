<?php
session_start();
include_once("accessoires/connect_bdd.php");
include_once("accessoires/auto_connexion.php");

$droits = verif_droit();

if($droits!=3){
	//On redirige vers la liste du type de jeu modifier;
	header('Location:index.php');
}
$id_jeu=$_GET['modifier'];
if (isset($_POST['modifier'])){//Si no a cliqué sur le bouton modifier depuis la page modifier.html
	
	//On récupère les donnée modifier
	$title_jeu=$_POST["title_jeu"];
	$description_jeu=$_POST["description_jeu"];
	$type_jeu=$_POST["type_jeu"];
	$text_jeu=$_POST["text_jeu"];
	
	//On met à jour la base de donnée
	$sql="UPDATE jeu SET title_jeu=:title_jeu, description_jeu=:description_jeu, type_jeu=:type_jeu, text_jeu=:text_jeu, date_update=NOW()
	      WHERE id_jeu=:id_jeu;";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_jeu',$title_jeu,PDO::PARAM_STR,50);
	$query->bindParam(':description_jeu',$description_jeu,PDO::PARAM_STR,350);
	$query->bindParam(':text_jeu',$text_jeu,PDO::PARAM_STR);
	$query->bindParam(':type_jeu',$type_jeu,PDO::PARAM_STR,30);
	$query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
	$query->execute();
	
	//On redirige vers la liste du type de jeu modifier;
	header('Location:liste.php?jeu='.$type_jeu);
}
if(isset($_GET['modifier'])){ //Si on a cliquer sur le bouton modifier
	
	//On récupère les données du jeu
	$sql="SELECT title_jeu, description_jeu, type_jeu, text_jeu FROM jeu WHERE id_jeu=:id_jeu ORDER BY type_jeu;";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
	$query->execute();
	
	//On enregistre les données récupérer dans des variables
	$data=$query->fetch(PDO::FETCH_ASSOC);
	$title_jeu=$data['title_jeu'];
	$description_jeu=$data['description_jeu'];
	$text_jeu=$data['text_jeu'];
	$type_jeu=$data['type_jeu'];
}
include_once("modifier_jeu.html");

?>