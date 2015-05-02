<?php
session_start();
session_regenerate_id();

include_once('accessoires/menu.php');
//l'auto connexion
auto_connexion(NULL,NULL,NULL);

include_once("accessoires/functions_events.php");
include_once("accessoires/functions_inscription.php");

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

//On s'inscrit ou se désinscrit d'un événement
if(isset($_GET['id']))
{
    $verif = verif_inscription($_GET['id'], "<=");
    if($verif==1)
    {
        header("location:actualite.php?#e".$_GET['id']);
    }
    else
    {
        $inscrit = recup_user_inscrit($_GET['id'], $_SESSION['id_user']);
        if (!$inscrit)
        {
            inscription_event($_GET['id']);
        }
        else
        {
            desinscription_event($_GET['id'], $_SESSION['id_user']);
        }
        header("location:actualite.php?#e".$_GET['id']);
    }
}

//On récupère les données en base de donnée
$query = recup_event($afficher);
$i=0;

//On parcourt les données pour les mettre dans des variables
while ($data=$query->fetch(PDO::FETCH_ASSOC))
{
	$id_event[$i]=$data['id_event'];

    //On récupére tous les utilisateurs inscrit à l'événement
    $query2 = recup_inscrit($id_event[$i]);
    $j = 0;
    while ($data2=$query2->fetch(PDO::FETCH_ASSOC))
    {
        $pseudo_inscrit[$j][$i] = $data2['pseudo'];
        $avatar_inscrit[$j][$i] = $data2['avatars'];
        $id_user_inscrit[$j][$i] = $data2['id_user'];
        $j++;
    }
	$title_event[$i] = $data['title_event'];
	$text_event[$i]=nl2br($data['text_event']);
	$image_event[$i]=$data['image_event'];
	$date_event[$i]=format_date($data['date_event']) ;
	$date_update[$i]=format_date($data['date_update']);
	$id_user_event[$i]=$data['id_user'];
    $id_jeu_event[$i]=$data['id_jeu'];
    $inscription_event[$i] = $data['inscription_event'];
    $nb_inscrit[$i] = $data['nb_inscrit'];
    if($id_jeu_event[$i]!=0)
    {
        $query2=recup_jeu($id_jeu_event[$i]);
        $data2=$query2->fetch(PDO::FETCH_ASSOC);
        $title_jeu_event[$i]=$data2['title_jeu'];
    }
	$i++;

}
if(isset($_SESSION['id_user']))
{
    $i=0;
    while (isset($id_event[$i]))
    {
        $nb[$i] = recup_user_inscrit($id_event[$i], $_SESSION['id_user']);
        $i++;
    }
}
//On affiche le tous dans le html
include_once("actualite.html");
?>