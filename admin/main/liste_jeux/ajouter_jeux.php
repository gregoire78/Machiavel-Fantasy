<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 27/04/2015
 * Time: 14:26
 */

//fonctions
include_once('../accessoires/functions_jeu.php');
include_once('../accessoires/functions_file.php');
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

    //on recupere les donnée cachées pour les verifier
    $dataX = htmlentities($_POST['dataX']);
    $dataY = htmlentities($_POST['dataY']);
    $dataHeight = htmlentities($_POST['dataHeight']);
    $dataWidth = htmlentities($_POST['dataWidth']);
    $backgroundColor = htmlentities($_POST['backgroundColor']);

    if(($dataHeight!='' || $dataWidth!='' || $dataX!='' || $dataY!=''))
    {
        if(is_numeric($dataX)==false || is_numeric($dataY)==false || is_numeric($dataHeight)==false || is_numeric($dataWidth)==false || is_numeric(hexdec(substr($backgroundColor,1,7)))==false)
        {
            $errors_jeu[0] = "Erreur 488 ... (donnée(s) interdite(s))";
        }
    }

    //Si on créer un jeu
    /********************** Vérifications pour le titre jeu ************************/
    $string = 50;
    if(empty($title_jeu))
    {
        $errors_jeu[1] = "Veuillez mettre un titre au jeu";
    }
    else if(strlen(html_entity_decode($title_jeu)) > $string)
    {
        $errors_jeu[1] = "Le titre ne doit pas dépasser <b>".$string." caractères</b>";
    }
    //vérifions s'il ya des caracteres speciaux
    else if(preg_match('/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ\- \']/',html_entity_decode($title_jeu)))
    {
        $errors_jeu[1] = "Veuillez n'insérer que des lettres ou chiffres dans le titre.";
    }
    //vérifions si le pseudo éxiste
    else if(verif_existe('id_jeu','jeu','title_jeu',$title_jeu)!=0)
    {
        $errors_jeu[1] = "Ce titre n'est pas disponible";
    }

    /*************** Vérifications pour le texte de contenu du jeu ******************/
    if(empty($text_jeu))
    {
        $errors_jeu[2] = "Veuillez remplir le jeu";
    }

    /********************** Vérifications pour l'image du jeu ************************/
    if(isset($_FILES['inputGameFile']) && $_FILES['inputGameFile']['size']>0)
    {
        $file = $_FILES['inputGameFile'];
        $crop = traitement_fichier($file,5000000,"jpg,jpeg,png,gif","image/jpeg,image/gif,image/png","photo");
        if(!$crop)
        {
            $nom_image_jeu = formatNomFichier(html_entity_decode($title_jeu));
            $crop = crop_image($file,$_POST['dataWidth'],$_POST['dataHeight'],$_POST['dataX'],$_POST['dataY'],150,'../images/jeux/',$nom_image_jeu,$_POST['backgroundColor']);
            if($crop)
            {
                $crop; // erreur de crop
            }
        }
        else
        {
            $crop; // erreurs de traitement de fichier
        }
    }
    else
    {
        $crop = "Veuillez Insérer une image d'illustration";
    }

    /**************************** Si il n'y a aucune erreur(s) *************************/
    if(empty($errors_jeu) && empty($crop))
    {
        $query=recup_id_type_jeu($libelle2);
        $id_type_jeu = $query->fetchColumn();
        if(isset($_POST['ajouter']))
        {
            //Si on ajoute un jeu
            create_jeu($title_jeu, $text_jeu, $nom_image_jeu, $id_type_jeu);

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