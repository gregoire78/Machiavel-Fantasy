<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('accessoires/functions_connect.php');
auto_connexion(NULL,NULL,NULL);

include_once('accessoires/menu.php');

include_once("accessoires/functions_events.php");
include_once("accessoires/functions_inscription.php");

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

$fichier_originel = "actualite.php";
$fichier = $fichier_num_page = $fichier_originel."?";

//Tableau pour les différents tris
$method_tri[0]="date_event";    $nom_tri[0]="Date de l'événement";
$method_tri[1]="date_update";   $nom_tri[1]="Date de mise à jour";
$method_tri[2]="title_event";   $nom_tri[2]="Titre de l'événement";

//On vérifie si on veut afficher les événements passer ou à venir
if(isset($_GET['passer']))
{
    $afficher='<';
    $fichier = $fichier."passer";
    $fichier_num_page  = $fichier;
}else
{
    $afficher='>=';
}

//Si on veut trier dans un ordre précis
if(isset($_GET['tri']) || isset($_GET['ordre']))
{
    //Si il y a une méthode de tri de dans l'URL
    if(isset($_GET['tri']))
    {
        switch($_GET['tri'])
        {
            case $method_tri[0]:
                $tri = $method_tri[0];
                break;
            case $method_tri[1]:
                $tri = $method_tri[1];
                break;
            case $method_tri[2]:
                $tri = $method_tri[2];
                break;
            default :
                $tri = $method_tri[0];
                break;
        }
        $fichier = $fichier."&tri=".$tri;
        $fichier_num_page = $fichier;
    }
    //Sinon on tri selon la première méthode de tri
    else
    {
        $tri = $method_tri[0];
    }

    //Si on un ordre de tri de dans l'URL
    if(isset($_GET['ordre']))
    {
        switch($_GET['ordre'])
        {
            case "Croissant":
                $ordre = "ASC";
                break;
            case "Décroissant":
                $ordre = "DESC";
                break;
            default :
                $ordre ="ASC";
                break;
        }
        $fichier = $fichier."&ordre=".$_GET['ordre'];
        $fichier_num_page =$fichier;
    }
    //Sinon on tri dans l'ordre croissant
    else
    {
        $ordre = "ASC";
    }
}
//Si on a aucun des deux tri dans l'URL
else
{
    //Si l'événement est passé on tri selon la première méthode par ordre décroissant sinon selon la première méthode par ordre croissant
    if(isset($_GET['passer']))
    {
        $ordre = "DESC";
    }
    else
    {
        $ordre ="ASC";
    }
    $tri = $method_tri[0];
}

//Si on a déjà un nombre de d'événement par page sinon par défaut on affichera 5 actu par page
if(isset($_GET['view']))
{
    switch($_GET['view'])
    {
        case 5 :
            $nombre_liste = 5;
            break;
        case 10 :
            $nombre_liste = 10;
            break;
        case 15 :
            $nombre_liste = 15;
            break;
        default :
            $nombre_liste = 5;
            break;
    }
    $fichier = $fichier."&view=".$nombre_liste;
}
else
{
    $nombre_liste = 5;
}

// On récupère le nombre de page pour afficher un nombre d'événement
$nb_page = recup_nb_page(recup_lign_event($afficher), $nombre_liste);

//Si on est déjà sur une page
if (isset ($_GET['page']))
{
    if ($_GET['page']>$nb_page || $_GET['page']< 1)
    {
        header('Location: ' . $referer);
    }
    else
    {
        $page = (int)$_GET['page'];
    }
}
else
{
    $page = 1;
}

//On s'inscrit ou se désinscrit d'un événement
if(isset($_SESSION['id_user']) && !isset($_GET['passer']) && $droits > 1 && (isset($_GET['desinscrire']) || isset($_GET['inscrire'])) )
{
    if (isset($_GET['inscrire']) && $verif = verif_inscription($_GET['inscrire'], ">") && !$inscrit = recup_user_inscrit($_GET['inscrire'], $_SESSION['id_user']))
    {
        inscription_event($_GET['inscrire']);
        header("location:".$fichier."&page=".$page."#e".$_GET['inscrire']);
    }
    else if(isset($_GET['desinscrire']) && $verif = verif_inscription($_GET['desinscrire'], ">=") && $inscrit = recup_user_inscrit($_GET['desinscrire'], $_SESSION['id_user']))
    {
        desinscription_user_event($_GET['desinscrire'], $_SESSION['id_user']);
        header("location:".$fichier."&page=".$page."#e".$_GET['desinscrire']);
    }
    else
    {
        header("location:".$fichier);
    }
}

if(isset($_GET['supprimer']))
{
    verif_mod_supp('event', $_GET['supprimer']);

    //Si l'utilisateur valide la suppression de l'événement
    if (isset($_POST['valider_supprimer']))
    {
        delete_event($_GET['supprimer']);
        desinscription_event($_GET['supprimer']);

		//On redirige vers l'actualité;
		header('Location:actualite.php');
	}
}

//On récupère les données en base de donnée
$query = recup_event($afficher, $_SESSION['id_user'], $page, $nombre_liste, $tri, $ordre );
$i=0;

//On parcourt les données pour les mettre dans des variables
while ($data=$query->fetch(PDO::FETCH_ASSOC))
{
	$id_event[$i]=$data['id_event_bis'];

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
    $id_jeu_event[$i]=$data['id_jeu_bis'];
    $inscription_event[$i] = $data['inscription_event'];
    $nb_inscrit[$i] = $data['nb_inscrit'];
    $title_jeu_event[$i]=$data['title_jeu'];
    $nb[$i] = $data['verif'];
	$i++;

}
//On affiche le tous dans le html
include_once("actualite.html");
?>