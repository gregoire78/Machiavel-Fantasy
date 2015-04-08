<?php
session_start();
include_once("accessoires/menu.php");
include_once("accessoires/functions_events.php");

if(isset($_GET['supprimer']))
{
	$supprimer=$_GET['supprimer'];
	verif_mod_supp('event', $supprimer);
	
	//Si l'utilisateur valide la suppression de l'événement
	if (isset($_POST['valider_supprimer']))
	{
		delete_event($supprimer);
		
		//On redirige vers l'actualité;
		header('Location:actualite.php');
	}
}

//On vérifie si on veut afficher les événements passer ou à venir
if(isset($_GET['passer']))
{
	$afficher='<';
}else
{
	$afficher='>=';
}

//On récupère les données en base de donnée
$query = recup_event($afficher);
$j=0;

//On parcourt les données pour les mettre dans des variables
while ($data=$query->fetch(PDO::FETCH_ASSOC))
{
	$id_event[$j]=$data['id_event'];
	$title_event[$j] = $data['title_event'];
	$text_event[$j]=nl2br($data['text_event']);
	$image_jeu[$j]=$data['image_jeu'];
	$date_event[$j]=format_date($data['date_event']) ;
	$date_update[$j]=format_date($data['date_update']);
	$id_jeu[$j]=$data['id_jeu'];
	$id_user_event[$j]=$data['id_user'];
	
	$pseudo_event[$j]=$data['pseudo'];
	$avatar_event[$j]=$data['avatars'];
	$j++;
}

//On affiche le tous dans le html
include_once("actualite.html");
?>