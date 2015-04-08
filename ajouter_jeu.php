<?php
session_start();
include_once("accessoires/functions_connect.php");
include_once("accessoires/auto_connexion.php");
$droits = verif_droit();

if($droits<2){
	//On redirige vers la liste du type de jeu modifier;
	header('Location:index.php');
}
if (isset($_POST["ajouter"])){
	include_once("accessoires/connect_bdd.php");
	
	//On récupère les données que l'utilisateur à envoyer.
	$title_jeu=$_POST["title_jeu"];
	$description_jeu=$_POST["description_jeu"];
	$type_jeu=$_POST["type_jeu"];
	$text_jeu=$_POST["text_jeu"];
	
	//On enregistre les données en base de donnée
	$sql="INSERT INTO jeu(title_jeu, description_jeu, type_jeu, text_jeu, date_update, id_user)
		  VALUES (:title_jeu,:description_jeu,:type_jeu,:text_jeu, NOW(),:id_user);";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_jeu',$title_jeu,PDO::PARAM_STR,50);
	$query->bindParam(':description_jeu',$description_jeu,PDO::PARAM_STR,350);
	$query->bindParam(':text_jeu',$text_jeu,PDO::PARAM_STR);
	$query->bindParam(':type_jeu',$type_jeu,PDO::PARAM_STR,30);
	$query->bindParam(':id_user',$id,PDO::PARAM_INT);
	$query->execute();
	
	//On redirige la personne vers la page du type de jeu qu'il vient d'enregistrer
	header('Location:liste.php?jeu='.$type_jeu);
}
include_once("ajouter_jeu.html");
?>