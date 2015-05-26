<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */

include_once("../functions/functions_historique.php");
include_once("../functions/functions_tools.php");

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

/*------ Tableau du nombre de vu par page -----------*/
$num_view[0]=10;
$num_view[1]=20;
$num_view[2]=30;
$num_view[3]=40;

//Tableau pour les différents tri
$method_tri[0]="date_historique";   $nom_tri[0]="Date";
$method_tri[1]="pseudo";            $nom_tri[1]="Nom d'utilisateur";

$method_ordre[0]="DESC";            $nom_ordre[0]="Décroissant";
$method_ordre[1]="ASC";             $nom_ordre[1]="Croissant";

/*------------- Tableau de couleur de texte d'utilisateur --------------*/
$color[0]="color: #333;"; //Banni
$color[1]="color: #597FB2;"; //Utilisateur
$color[2]="color: #26AB40;"; //Adhérent
$color[3]="color: #AA0000;"; //Administrateur

$table_historique = 3;
$delall = 0;
$delmark = 0;

if (isset($_GET['m']))
{
        switch ($_GET['m'])
        {
            case "global" :
                $titre_maintenance = "Journal global";
                $text_maintenance = "Liste toutes les actions.";
                $restrict = NULL;
                $fichier_originel = "index.php?i=maintenance&m=global";
                $method_tri[2]="text_historique";   $nom_tri[2]="Journal d'action";
                break;
            case "forum" :
                $titre_maintenance = "Journal du forum";
                $text_maintenance = "Liste toutes les actions effectuées sur le forum.";
                $restrict = 1;
                $fichier_originel = "index.php?i=maintenance&m=forum";
                break;
            case "evenement" :
                $titre_maintenance = "Journal d'événement";
                $text_maintenance = "Liste toutes inscription, désinscription, création, modification et suppression d'événement.";
                $restrict = 2;
                $fichier_originel = "index.php?i=maintenance&m=evenement";
                break;
            case "administration" :
                $titre_maintenance = "Journal d'administration";
                $text_maintenance = "Liste toutes les actions effectuées au sein du panneau d'administration.";
                $restrict = 3;
                $fichier_originel = "index.php?i=maintenance&m=administration";
                break;
            case "jeu" :
                $titre_maintenance = "Journal de jeu";
                $text_maintenance = "Liste toutes les actions effectuées sur les jeux.";
                $restrict = 4;
                $fichier_originel = "index.php?i=maintenance&m=jeu";
                break;
            case "utilisateur" :
                $titre_maintenance = "Journal d'utilisateur";
                $text_maintenance = "Liste toutes les actions effectuées par les utilisateurs ou sur les utilisateurs.";
                $restrict = 5;
                $fichier_originel = "index.php?i=maintenance&m=utilisateur";
                break;
            default  :
                $titre_maintenance = "Journal global";
                $text_maintenance = "Liste toutes les actions.";
                $restrict = NULL;
                $fichier_originel = "index.php?i=maintenance&m=global";
                break;
        }
}
else
{
    $titre_maintenance = "Journal global";
    $text_maintenance = "Liste toutes les actions";
    $restrict = NULL;
    $fichier_originel = "index.php?i=maintenance";
}

$fichier = $fichier_originel;

$tri_result = tri_result($method_tri,$method_ordre, $fichier);
$tri = $tri_result['tri'];
$ordre = $tri_result['ordre'];
$fichier = $tri_result['fichier'];
$fichier_num_page = $tri_result['fichier'];

$view_result = view($num_view, $fichier);
$view = $view_result['view'];
$fichier = $view_result['fichier'];

// On récupère le nombre de page pour afficher un nombre d'événement
$nb_historique = recup_lign_historique($restrict);
$nb_page = recup_nb_page($nb_historique, $view);
$page = page($nb_page, $referer);


if(isset($_POST['delmarked']))
{
    $delmark = 1;
    $i=0;
    if(isset($_POST['mark']))
    {
        foreach($_POST['mark'] as $mark=> $cocher[$i])
        {
            $cocher[$i];
            $i++;
        }
        $del_restrict = NULL;
    }
}

if(isset($_POST['delall']))
{
    $delall = 1;
    if($_POST['delall']==1)
    {
        $del_restrict = $restrict;
        $cocher=NULL;
    }
}

if(isset($_POST["confirm"]))
{
    delete_historique($cocher, $del_restrict);
    create_historique($table_historique, "Journal d'administration effacé", $_SESSION['id_user']);
    header("location:".$fichier);
}else if(isset($_POST["cancel"]))
{
    header("location:".$fichier);
}

$query = recup_historique($restrict,$tri , $ordre, $page, $view);

$i=0;

//On parcourt les données pour les mettre dans des variables
if($nb_historique!=0)
{
    while ($data=$query->fetch(PDO::FETCH_ASSOC))
    {
        $id_historique[$i] = $data['id_historique'];
        $id_user_historique[$i] = $data['id_user'];
        $pseudo_historique[$i] = $data['pseudo'];
        $avatar_historique[$i] = $data['avatars'];
        $text_historique[$i] = $data['text_historique'];
        $date_historique[$i] = format_date($data['date_historique']);
        switch ($data['droits'])
        {
            case 0 :
                $color_user[$i]= $color[0];
                break;
            case 1 :
                $color_user[$i]= $color[1];
                break;
            case 2 :
                $color_user[$i]= $color[2];
                break;
            case 3 :
                $color_user[$i]= $color[3];
                break;
            default :
                $color_user[$i]= $color[0];
                break;
        }
        $i++;
    }
}
else
{
    $error = "Aucune entrée au journal";
}

include_once("maintenance.html");
?>