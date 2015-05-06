<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 24/04/2015
 * Time: 20:26
 */

include_once("../accessoires/functions_historique.php");
include_once("../accessoires/functions_tools.php");


if (isset($_GET['m'])) {
    switch ($_GET['m']) {
        case "global" :
            $titre_maintenance = "Journal global";
            $text_maintenance = "text1";
            $restrict = "";
            $fichier = "index.php?i=maintenance&m=global";
            break;
        case "administration" :
            $titre_maintenance = "Journal d'administration";
            $text_maintenance = "text2";
            $restrict = "WHERE table_historique = 3";
            $fichier = "index.php?i=maintenance&m=administration";
            break;
        case "jeu" :
            $titre_maintenance = "Journal de jeu";
            $text_maintenance = "text3";
            $restrict = "WHERE table_historique = 4";
            $fichier = "index.php?i=maintenance&m=jeu";
            break;
        case "forum" :
            $titre_maintenance = "Journal du forum";
            $text_maintenance = "text4";
            $restrict = "WHERE table_historique = 1";
            $fichier = "index.php?i=maintenance&m=forum";
            break;
        case "evenement" :
            $titre_maintenance = "Journal d'événement";
            $text_maintenance = "text5";
            $restrict = "WHERE table_historique = 2";
            $fichier = "index.php?i=maintenance&m=evenement";
            break;
        case "utilisateur" :
            $titre_maintenance = "Journal d'utilisateur";
            $text_maintenance = "text6";
            $restrict = "WHERE table_historique = 5";
            $fichier = "index.php?i=maintenance&m=utilisateur";
            break;
        default  :
            $titre_maintenance = "Journal global";
            $text_maintenance = "text1";
            $restrict = "";
            $fichier = "index.php?i=maintenance&m=global";
            break;
    }
} else {
    $titre_maintenance = "Journal global";
    $text_maintenance = "text1";
    $restrict = "";
    $fichier = "index.php?i=maintenance&m=global";
}

//Si on a déjà un nombre de d'événement par page sinon par défaut on affichera 5 actu par page
if(isset($_GET['view']))
{
    switch($_GET['view'])
    {
        case 10 :
            $nombre_liste = 10;
            break;
        case 20 :
            $nombre_liste = 20;
            break;
        case 30 :
            $nombre_liste = 30;
            break;
        default :
            $nombre_liste = 10;
            break;
    }
    $fichier = $fichier."&view=".$nombre_liste;
}
else
{
    $nombre_liste = 10;
}

// On récupère le nombre de page pour afficher un nombre d'événement
$nb_page = recup_nb_page(recup_lign_historique($restrict), $nombre_liste);

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
$query = recup_historique($restrict, $ordre, $page, $nombre_liste);

$i=0;

//On parcourt les données pour les mettre dans des variables
while ($data=$query->fetch(PDO::FETCH_ASSOC))
{
    $id_historique[$i] = $data['id_historique'];
    $id_user_historique[$i] = $data['id_user'];
    $pseudo_historique[$i] = $data['pseudo'];
    $avatar_historique[$i] = $data['avatars'];
    $text_historique[$i] = $data['text_historique'];
    $date_historique[$i] = format_date($data['date_historique']);
    $i++;
}

include_once("maintenance.html");
?>