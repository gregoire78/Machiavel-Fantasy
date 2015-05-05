<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 27/04/2015
 * Time: 14:26
 */

//fonctions
include_once('../accessoires/functions_jeu.php');
include_once('../accessoires/functions_crop.php');
include_once('../accessoires/menu.php');

//Si on veut éditer un jeu, on récupère les données
if(isset($_GET['jeu'])){
    $id_jeu=$_GET['jeu'];
    $query = recup_jeu($id_jeu);
    $data=$query->fetch(PDO::FETCH_ASSOC);
    $title_jeu=$data['title_jeu'];
    $text_jeu=$data['text_jeu'];
    $id_user_jeu=$data['id_user'];
    $id_type_jeu=$data['id_type_jeu'];
    $image_jeu=$data['image_jeu'];
    /*if($statut_menu>3 && $id_user_article!=$id){
        header("Location:index.php");
    }*/
}
else
{
    $image_jeu = 'defaut_jeu.png';
}
//Si on envoie des données en POST
if(isset($_POST['ajouter'])||isset($_POST['modifier']))
{
    //On recupère les données en poste
    $title_jeu=htmlentities(trim($_POST['title_jeu']));
    $text_jeu=trim($_POST['text_jeu']);
    $libelle2=$_POST['libelle'];

    //Si on créer un jeu
    /****verif titre*****/
    $string = 50;
    if(empty($title_jeu))
    {
        $errors_jeu[1] = "Veuillez mettre un titre au jeu";
    }
    else
    {
        if(strlen(html_entity_decode($title_jeu)) > $string)
        {
            $errors_jeu[1] = "Le titre ne doit pas dépasser <b>".$string." caractères</b>";
        }
        else
        {
            //vérifions s'il ya des caracteres speciaux
            if(preg_match("/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ.:!?_\' ]/",$_POST['title_jeu']))
            {
                $errors_jeu[1] = "Veuillez n'insérer que des lettres ou chiffres dans le titre.";
            }
        }
    }
    /***verif text**/
    if(empty($text_jeu))
    {
        $errors_jeu[2] = "Veuillez remplir le jeu";
    }


    if(isset($_FILES['inputGameFile']) && $_FILES['inputGameFile']['size']>0)
    {
        $file = $_FILES['inputGameFile'];
        $crop = traitement_fichier($file,5000000,"jpg,jpeg,png,gif","image/jpeg,image/gif,image/png","photo");
        if(!$crop)
        {
            $nom_image_jeu = sha1(last_jeu_id());
            $crop = crop_image($file,$_POST['dataWidth'],$_POST['dataHeight'],$_POST['dataX'],$_POST['dataY'],150,200,'../images/jeux/',$nom_image_jeu,$_POST['backgroundColor']);
            if($crop)
            {
                echo $crop; // erreur de crop
            }
        }
        else
        {
            echo $crop; // erreurs de traitement de fichier
        }
    }

    if(empty($errors_jeu) && empty($crop))
    {
        $query=recup_id_type_jeu($libelle2);
        $id_type_jeu = $query->fetchColumn();
        if(isset($_POST['ajouter']))
        {
            //Si on ajoute un jeu
            create_jeu($title_jeu, $text_jeu, 'defaut_jeu.png', $id_type_jeu);

            header("Location:/liste_jeu.php?jeu=".$id_type_jeu);
        }
        /*else if(isset($_POST['modifier']))
        {
            //Si on modifie un jeu
            $id_jeu=$_GET['jeu'];
            update_jeu($title_jeu, $text_jeu, $dossier.$fichier, $id_type_jeu, $id_jeu);
            upload_avatar($jeu_file_tmp,$fichier,$dossier);
        }*/
        //On redirige vers le type d'actualité


    }

}

include_once("ajouter_jeux.html");