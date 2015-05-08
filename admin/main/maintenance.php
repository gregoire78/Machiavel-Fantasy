<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */

include_once("../accessoires/functions_historique.php");
include_once("../accessoires/functions_tools.php");

/*------ Tableau du nombre de vu par page -----------*/
$view[0]=10;
$view[1]=20;
$view[2]=30;
$view[3]=40;

//Tableau pour les différents tris
$method_tri[0]="date_historique";   $nom_tri[0]="Date";
$method_tri[1]="pseudo";            $nom_tri[1]="Nom d'utilisateur";
$method_tri[2]="text_historique";   $nom_tri[2]="Journal d'action";

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
                $restrict = "WHERE 1";
                $fichier_originel = "index.php?i=maintenance&m=global";
                break;
            case "administration" :
                $titre_maintenance = "Journal d'administration";
                $text_maintenance = "Liste toutes les actions effectuées au sein du panneau d'administration.";
                $restrict = "WHERE table_historique = 3";
                $fichier_originel = "index.php?i=maintenance&m=administration";
                break;
            case "jeu" :
                $titre_maintenance = "Journal de jeu";
                $text_maintenance = "Liste toutes les actions effectuées sur les jeux.";
                $restrict = "WHERE table_historique = 4";
                $fichier_originel = "index.php?i=maintenance&m=jeu";
                break;
            case "forum" :
                $titre_maintenance = "Journal du forum";
                $text_maintenance = "Liste toutes les actions effectuées sur le forum.";
                $restrict = "WHERE table_historique = 1";
                $fichier_originel = "index.php?i=maintenance&m=forum";
                break;
            case "evenement" :
                $titre_maintenance = "Journal d'événement";
                $text_maintenance = "Liste toutes inscription, désinscription, création, modification et suppression d'événement.";
                $restrict = "WHERE table_historique = 2";
                $fichier_originel = "index.php?i=maintenance&m=evenement";
                break;
            case "utilisateur" :
                $titre_maintenance = "Journal d'utilisateur";
                $text_maintenance = "Liste toutes les actions effectuées par les utilisateurs ou sur les utilisateurs.";
                $restrict = "WHERE table_historique = 5";
                $fichier_originel = "index.php?i=maintenance&m=utilisateur";
                break;
            default  :
                $titre_maintenance = "Journal global";
                $text_maintenance = "Liste toutes les actions.";
                $restrict = " WHERE 1";
                $fichier_originel = "index.php?i=maintenance&m=global";
                break;
        }
}
else
{
    $titre_maintenance = "Journal global";
    $text_maintenance = "Liste toutes les actions";
    $restrict = "WHERE 1";
    $fichier_originel = "index.php?i=maintenance";
}

$fichier = $fichier_num_page = $fichier_originel;

//Si on a déjà un nombre de d'événement par page sinon par défaut on affichera 5 actu par page
if(isset($_GET['view']))
{
    switch($_GET['view'])
    {
        case $view[0] :
            $nombre_liste = $view[0];
            break;
        case $view[1] :
            $nombre_liste = $view[1];
            break;
        case $view[2] :
            $nombre_liste = $view[2];
            break;
        case $view[3] :
            $nombre_liste = $view[3];
            break;
        default :
            $nombre_liste = $view[0];
            break;
    }
    $fichier = $fichier."&view=".$nombre_liste;
}
else
{
    $nombre_liste = $view[0];
}
// On récupère le nombre de page pour afficher un nombre d'événement
$nb_historique = recup_lign_historique($restrict);
$nb_page = recup_nb_page($nb_historique, $nombre_liste);

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


//Si il y a une méthode de tri de dans l'URL
if(isset($_POST['tri']) || isset($_GET['tri']))
{
    if(isset($_POST['tri']))
    {
        $switch_tri = $_POST['tri'];
    }
    else if(isset($_GET['tri']))
    {
        $switch_tri = $_GET['tri'];
    }
    switch($switch_tri)
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
        case $method_tri[3]:
            $tri = $method_tri[3];
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

if(isset($_POST['ordre']) || isset($_GET['ordre']))
{
    if(isset($_POST['ordre']))
    {
        $switch_ordre = $_POST['ordre'];
    }
    else if (isset($_GET['ordre']))
    {
        $switch_ordre = $_GET['ordre'];
    }
    switch($switch_ordre)
    {
        case "Croissant":
            $ordre = "ASC";
            break;
        case "Décroissant":
            $ordre = "DESC";
            break;
        default :
            $ordre ="DESC";
            break;
    }
    $fichier = $fichier."&ordre=".$ordre;
    $fichier_num_page =$fichier;
}
//Sinon on tri dans l'ordre décroissant
else
{
    $ordre = "DESC";
}


if(isset($_POST['delmarked']))
{
    $delmark = 1;
    $i=0;

    $del_restrict = "WHERE id_historique IN (0" ;
    if(isset($_POST['mark']))
    {
        foreach($_POST['mark'] as $mark=> $cocher[$i])
        {
            $del_restrict = $del_restrict.", ".$cocher[$i];
            $i++;
        }
    }
    $del_restrict = $del_restrict.")";
}

if(isset($_POST['delall']))
{
    $delall = 1;
    if($_POST['delall']==1) $del_restrict = $restrict;
}

if(isset($_POST["confirm"]))
{
    delete_historique($del_restrict);
    create_historique($table_historique, "Journal d'administration effacé", $_SESSION['id_user']);
    header("location:".$fichier);
}else if(isset($_POST["cancel"]))
{
    header("location:".$fichier);
}

$query = recup_historique($restrict,$tri , $ordre, $page, $nombre_liste);

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
    $error = "Aucune entrée au journal.";
}

include_once("maintenance.html");
?>