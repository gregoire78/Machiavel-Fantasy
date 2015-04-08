<?php
session_start();

//fonctions
include_once('accessoires/menu.php');

//l'auto connexion
auto_connexion(NULL,'index.php',2);

require("accessoires/connect_bdd.php");//a enlever

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
//Si on envoie des données en POST
if(isset($_POST['ajouter'])||isset($_POST['modifier']))
{
	//On recupère les données en poste
	$title_jeu=htmlentities(trim($_POST['title_jeu']));
	$text_jeu=trim($_POST['text_jeu']);
	$libelle2=$_POST['libelle'];
	$article_file = $_FILES['inputArticleFile']['name'];
	$article_file_tmp = $_FILES['inputArticleFile']['tmp_name'];

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
	/***verif image jeu**/
	/*if(empty($jeu_file) && isset($_POST['ajouter']))
	{
		$errors_jeu[4] = 'Veuillez ajoutez une image';
	}*/
    /*
	else if(!empty($jeu_file))
	{
		$dossier = 'images/jeux/';
		$taille_maxi = 500000;
		$extensions = array('.png', '.jpg', '.jpeg');

		$fichier = basename($jeu_file);
		$fichier = wd_remove_accents($fichier, $charset='utf-8');
		$taille = filesize($jeu_file_tmp);
		$extension = strrchr($jeu_file, '.');

		if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
		{
			$errors_jeu[4] = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
		}
		else
		{
			if($taille>$taille_maxi)
			{
				$errors_jeu[4] = "L'image est supérieur à <b>500 Ko</b>";
			}
		}
	}
	else
	{
		$fichier = $image_jeu;
	}
*/
	if(empty($errors_jeu))
	{
		$query=recup_id_type_jeu($libelle2);
        $id_type_jeu = $query->fetchColumn();
		if(isset($_POST['ajouter']))
		{
			//Si on ajoute un jeu
			create_jeu($title_jeu, $text_jeu, 'fgfgf', $id_type_jeu);
			//upload_avatar($jeu_file_tmp,$fichier,$dossier);
			
		}
		/*else if(isset($_POST['modifier']))
		{
			//Si on modifie un jeu
			$id_jeu=$_GET['jeu'];
			update_jeu($title_jeu, $text_jeu, $dossier.$fichier, $id_type_jeu, $id_jeu);
			upload_avatar($jeu_file_tmp,$fichier,$dossier);
		}*/
		//On redirige vers le type d'actualité
		
		header("Location:liste_jeu.php?jeu=".$id_type_jeu);
	}

}
include_once("edit_jeu.html");