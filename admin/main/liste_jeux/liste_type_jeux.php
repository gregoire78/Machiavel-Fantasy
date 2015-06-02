<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 25/04/2015
 * Time: 17:19
 */
include_once("../functions/functions_jeu.php");
include_once("../functions/functions_tools.php");

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

$titre_liste = "Gérer les catégories de jeu";
$text_liste = "Liste des catégories de jeu. Vous pouvez modifier le contenu d'une catégorie ou la supprimer.";

$table_historique = 4;
$delall = 0;
$delmark = 0;


$fichier = "index.php?i=liste_jeux&j=liste_type_jeux";

if(isset($_GET['confirm']))
{
    include_once("../functions/functions_historique.php");
    $query = recup_type_jeu_one($_GET['confirm']);
    $data=$query->fetch(PDO::FETCH_ASSOC);
    delete_type_jeu($_GET['confirm']);
    create_historique($table_historique, "La catégorie ".$data['libelle_type_jeu']." a été supprimé", $_SESSION['id_user']);
    header("location:".$fichier);
}

$query = recup_type_jeu();
if (isset($query))
{
    $i=0;
    while ($data=$query->fetch(PDO::FETCH_ASSOC))
    {
        $id_type_jeu[$i]= $data['id_type_jeu'];
        $libelle_type_jeu[$i]= $data['libelle_type_jeu'];
        $image_type_jeu[$i]=$data['image_type_jeu'];
        $icon_type_jeu[$i]=$data['icon_type_jeu'];
        $color_type_jeu[$i]=$data['color_type_jeu'];
        $description_type_jeu[$i]=$data['description_type_jeu'];
        $i++;
    }
}
else
{
    $error = "Il y a aucune catégorie enregistré";
}
include_once("liste_type_jeux.html");
?>