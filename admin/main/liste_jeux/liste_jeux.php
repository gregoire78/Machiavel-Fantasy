<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 25/04/2015
 * Time: 17:17
 */

include_once("../functions/functions_jeu.php");
include_once("../functions/functions_tools.php");

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

$titre_liste = "Gérer les jeux";
$text_liste = "Liste tous les jeux du club. Vous pouvez les trier par titre ou par catégorie de jeu. Vous pouvez les activer ou désactiver en cliquant sur son statut. Vous pouvez modifier un jeu en cliquant sur son titre";

/*------ Tableau du nombre de vu par page -----------*/
$num_view[0]=10;
$num_view[1]=20;
$num_view[2]=30;
$num_view[3]=40;

//Tableau pour les différents tri
$method_tri[0]="title_jeu";         $nom_tri[0]="Titre de jeu";
$method_tri[1]="j.id_type_jeu";     $nom_tri[1]="Catégorie de jeu";

$method_ordre[0]="ASC";             $nom_ordre[0]="Croissant";
$method_ordre[1]="DESC";            $nom_ordre[1]="Décroissant";

$color_desactive="#F8C3C3;"; //Couleur de fond pour les jeux désactivés

$table_historique = 4;
$delall = 0;
$delmark = 0;
$resultats = "jeux";

$fichier_originel = "index.php?i=liste_jeux&j=liste_jeux";
$fichier = $fichier_originel;

//On récupère les résultats actifs, inactif ou tout confondu
$affiche_active = affiche_active($fichier, "jeu");
$affiche_jeu = $affiche_active['active'];
$fichier = $affiche_active['fichier'];
$error = $affiche_active['error'];

//On trie récupère le tri de l'utilisateur
$tri_result = tri_result($method_tri,$method_ordre, $fichier);
$tri = $tri_result['tri'];
$ordre = $tri_result['ordre'];
$fichier = $tri_result['fichier'];
$fichier_num_page = $tri_result['fichier'];

//On récupère le nombre de vu de l'utilisateur
$view_result = view($num_view, $fichier);
$view = $view_result['view'];
$fichier = $view_result['fichier'];


// On récupère le nombre de page pour afficher un nombre d'événement
$nb_jeu = recup_lign(NULL, $affiche_jeu);
$nb_page = recup_nb_page($nb_jeu, $view);
$page = page($nb_page, $referer);

if(isset($_GET["jeu"]))
{
    include_once("../functions/functions_historique.php");
    $query = recup_liste_jeu(NULL, NULL, NULL, NULL, NULL, $_GET["jeu"], NULL);
    $data=$query->fetch(PDO::FETCH_ASSOC);
    if($data['statut_jeu']==0)
    {
        $active_jeu = "activé";
        $new_statut_jeu = 1;
    }
    else if($data['statut_jeu']==1)
    {
        $active_jeu = "désactivé";
        $new_statut_jeu = 0;
    }
    else
    {
        header("location:".$fichier);
    }
    active_jeu($new_statut_jeu, $_GET["jeu"]);
    create_historique($table_historique, "Le jeu ".$data['title_jeu']." a été ".$active_jeu, $_SESSION['id_user']);
    header("location:".$fichier."#j".$_GET['jeu']);
}

$query = recup_liste_jeu(NULL ,$tri , $ordre, $page, $view, NULL, $affiche_jeu);

$i=0;

//On parcourt les données pour les mettre dans des variables
if($nb_jeu!=0)
{
    while ($data=$query->fetch(PDO::FETCH_ASSOC))
    {
        $id_jeu[$i] = $data['id_jeu'];
        $title_jeu[$i] = $data['title_jeu'];
        $statut_jeu[$i] = $data['statut_jeu'];
        $image_jeu[$i] = $data['image_jeu'];
        $text_jeu[$i]=strip_tags(substr(($data['text_jeu']),0,300))." ...";
        $libelle_type_jeu[$i] = $data['libelle_type_jeu'];
        $color_type_jeu[$i] = $data['color_type_jeu'];
        $i++;
    }
}

include_once("liste_jeux.html");
?>