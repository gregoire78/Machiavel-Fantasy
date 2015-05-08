<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('accessoires/functions_connect.php');
auto_connexion(NULL,NULL,0);

//fonctions
include_once('accessoires/menu.php');
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';


$method_tri[0]="title_jeu";    $nom_tri[0]="Titre de jeu";
$method_tri[1]="date_update";   $nom_tri[1]="Date de mise à jour";

//Tableau pour les diffrents nombre d'affichage par pages
$view[0]=5;
$view[1]=10;
$view[2]=15;

if(!isset($_GET['jeu']))
{
    header('Location: ' . $referer);
}

//On récupère les informations concernant le type de jeu	(.accessoires/functions_jeu.php)
$query = recup_type_jeu_one($_GET['jeu']);
$data=$query->fetch(PDO::FETCH_ASSOC);
$libelle_type_jeu = $data['libelle_type_jeu'];
$description_type_jeu = $data['description_type_jeu'];
$color_type_jeu = $data['color_type_jeu'];
$icon_type_jeu = $data['icon_type_jeu'];

$fichier_originel = "liste_jeu.php?jeu=".$_GET['jeu'];
$fichier = $fichier_num_page = $fichier_originel;

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
            $ordre ="ASC";
            break;
    }
    $fichier = $fichier."&ordre=".$ordre;
    $fichier_num_page =$fichier;
}
//Sinon on tri dans l'ordre décroissant
else
{
    $ordre ="ASC";
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

//On récupère le nombre de page pour afficher le nombre de jeu dans la base de donnée
$nb_page = recup_nb_page(recup_lign($_GET['jeu']), $nombre_liste);

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

//On récupère la liste des jeux en base de donnée			(.accessoires/functions_jeu.php)
$query=recup_liste_jeu($_GET['jeu'], $tri, $ordre, $page, $nombre_liste);
$j=0;

//On parcourt les jeux de la base de donnée
while ($data=$query->fetch(PDO::FETCH_ASSOC))
{
	$id_jeu[$j]= $data['id_jeu'];
	$title_jeu[$j]=$data['title_jeu'];
	$image_jeu[$j]=$data['image_jeu'];
	$text_jeu[$j]=strip_tags(substr(($data['text_jeu']),0,300))." ...";
	$date_update[$j]=date("d/m/Y",strtotime ($data['date_update']));
	$j++;
}
include_once("liste_jeu.html");

?>