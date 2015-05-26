<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('functions/functions_connect.php');
auto_connexion(NULL,NULL,0);

//fonctions
include_once('accessoires/menu.php');
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

$method_ordre[0]="ASC";         $nom_ordre[0]="Croissant";
$method_ordre[1]="DESC";        $nom_ordre[1]="Décroissant";

$method_tri[0]="title_jeu";     $nom_tri[0]="Titre de jeu";
$method_tri[1]="date_update";   $nom_tri[1]="Date de mise à jour";

//Tableau pour les diffrents nombre d'affichage par pages
$num_view[0]=5;
$num_view[1]=10;
$num_view[2]=15;

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
$fichier = $fichier_originel;

$tri_result = tri_result($method_tri,$method_ordre, $fichier);
$tri = $tri_result['tri'];
$ordre = $tri_result['ordre'];

$fichier = $tri_result['fichier'];
$fichier_num_page = $tri_result['fichier'];

$view_result = view($num_view, $fichier);
$view = $view_result['view'];
$fichier = $view_result['fichier'];

//On récupère le nombre de page pour afficher le nombre de jeu dans la base de donnée
$nb_page = recup_nb_page(recup_lign($_GET['jeu']), $view);

$page = page($nb_page, $referer);

//On récupère la liste des jeux en base de donnée			(.accessoires/functions_jeu.php)
$query=recup_liste_jeu($_GET['jeu'], $tri, $ordre, $page, $view);
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