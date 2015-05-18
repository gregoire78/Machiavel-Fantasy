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
$fichier = $fichier_originel."?";

$table_historique = 2;

//Tableau pour les différents tris
$method_tri[0]="date_event";    $nom_tri[0]="Date de l'événement";
$method_tri[1]="date_update";   $nom_tri[1]="Date de mise à jour";
$method_tri[2]="title_event";   $nom_tri[2]="Titre de l'événement";
$method_tri[3]="title_jeu";     $nom_tri[3]="Jeux";

//Tableau pour les diffrents nombre d'affichage par pages
$num_view[0]=5;
$num_view[1]=10;
$num_view[2]=15;

//On vérifie si on veut afficher les événements passer ou à venir
if(isset($_GET['passer']))
{
    $afficher="<";
    $fichier = $fichier."passer";
    $fichier_num_page  = $fichier;
    $method_ordre[0]="DESC";        $nom_ordre[0]="Décroissant";
    $method_ordre[1]="ASC";         $nom_ordre[1]="Croissant";
}else
{
    $afficher='>=';
    $method_ordre[0]="ASC";         $nom_ordre[0]="Croissant";
    $method_ordre[1]="DESC";        $nom_ordre[1]="Décroissant";
}

$tri_result = tri_result($method_tri,$method_ordre, $fichier);
$tri = $tri_result['tri'];
$ordre = $tri_result['ordre'];

$fichier = $tri_result['fichier'];
$fichier_num_page = $tri_result['fichier'];

$view_result = view($num_view, $fichier);
$view = $view_result['view'];
$fichier = $view_result['fichier'];

// On récupère le nombre de page pour afficher un nombre d'événement
$nb_page = recup_nb_page(recup_lign_event($afficher), $view);

$page = page($nb_page, $referer);


//On s'inscrit ou se désinscrit d'un événement
if(isset($_SESSION['id_user']) && !isset($_GET['passer']) && $droits > 1 && (isset($_GET['desinscrire']) || isset($_GET['inscrire'])) )
{
    include_once("accessoires/functions_historique.php");
    if (isset($_GET['inscrire']) && $verif = verif_inscription($_GET['inscrire'], ">") && !$inscrit = recup_user_inscrit($_GET['inscrire'], $_SESSION['id_user']))
    {
        $query = recup_event_one($_GET['inscrire']);
        $data=$query->fetch(PDO::FETCH_ASSOC);
        $title_event_inscrit = $data['title_event'];
        create_historique($table_historique, "Inscription à l'événement : ".$title_event_inscrit, $_SESSION['id_user']);
        inscription_event($_GET['inscrire']);
        header("location:".$fichier."&page=".$page."#e".$_GET['inscrire']);
    }
    else if(isset($_GET['desinscrire']) && $verif = verif_inscription($_GET['desinscrire'], ">=") && $inscrit = recup_user_inscrit($_GET['desinscrire'], $_SESSION['id_user']))
    {
        $query = recup_event_one($_GET['desinscrire']);
        $data=$query->fetch(PDO::FETCH_ASSOC);
        $title_event_desinscrit = $data['title_event'];
        create_historique($table_historique, "Désinscription de l'événement : ".$title_event_desinscrit, $_SESSION['id_user']);
        desinscription_user_event($_GET['desinscrire'], $_SESSION['id_user']);
        header("location:".$fichier."&page=".$page."#e".$_GET['desinscrire']);
    }
    else
    {
        header("location:".$fichier."&page=".$page);
    }
}else if(isset($_GET['passer']) && (isset($_GET['desinscrire']) || isset($_GET['inscrire'])))
{
    header("location:".$fichier."&page=".$page);
}

if(isset($_GET['supprimer']))
{
    include_once("accessoires/functions_historique.php");
   verif_mod_supp('event', $_GET['supprimer']);

    //Si l'utilisateur valide la suppression de l'événement
    if (isset($_POST['valider_supprimer']))
    {
        $query = recup_event_one( $_GET['supprimer']);
        $data=$query->fetch(PDO::FETCH_ASSOC);
        $title_event_supp = $data['title_event'];
        create_historique($table_historique, "Suppression de l'événement : ".$title_event_supp, $_SESSION['id_user'] );
        delete_event($_GET['supprimer']);
        desinscription_event($_GET['supprimer']);

		//On redirige vers l'actualité;
		header('Location:actualite.php');
	}
}

if(!isset($_SESSION['id_user']))
{
    $_SESSION['id_user'] = NULL;
}
//On récupère les données en base de donnée
$query = recup_event($afficher, $_SESSION['id_user'], $page, $view, $tri, $ordre );
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
	$date_event[$i]=format_date($data['date_event']);
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