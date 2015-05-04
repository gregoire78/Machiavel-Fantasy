<?php
/*------------------------------------ TABLE TYPE_JEU--------------------------------------------*/
//Fonction pour récupérer id_type_jeu et libelle_type_jeu de la table type_jeu
function recup_type_jeu()
{
	require("connect_bdd.php");
	$sql="SELECT * FROM type_jeu;";
	$query=$connect->prepare($sql);
	$query->execute();
	return $query;
}

//Fonction pour récupérer les information concernant a l'id_type_jeu
function recup_type_jeu_one($id_type_jeu)
{
	require("connect_bdd.php");
	$sql="	SELECT  libelle_type_jeu, description_type_jeu, color_type_jeu, icon_type_jeu, image_type_jeu
			FROM    type_jeu
			WHERE   id_type_jeu=:id_type_jeu";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
	$query->execute();
	return $query;
}

//Fonction pour récupérer l'id_type_jeu correspondant au libelle_type_jeu
function recup_id_type_jeu($libelle_type_jeu)
{
	require("connect_bdd.php");
	$sql="	SELECT  id_type_jeu, image_type_jeu
			FROM    type_jeu
			WHERE   libelle_type_jeu=:libelle_type_jeu";
	$query=$connect->prepare($sql);
	$query->bindParam(':libelle_type_jeu',$libelle_type_jeu,PDO::PARAM_STR);
	$query->execute();
	return $query;	
}

/*-----------------------------TABLE JEU-----------------------------------------*/
//Fonction pour récupérer tous les jeux d'un type (page liste_jeu)
function recup_liste_jeu($id_type_jeu, $page, $jeu_page)
{
	$nb_jeu = ($page-1)*$jeu_page;
	require("connect_bdd.php");
	$sql="	SELECT id_jeu, title_jeu, text_jeu, image_jeu, date_update
			FROM   jeu
			WHERE  id_type_jeu=:id_type_jeu AND statut_jeu = 1
			ORDER BY title_jeu ASC
			LIMIT   :nb_jeu, :jeu_page";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
	$query->bindParam(':nb_jeu',$nb_jeu,PDO::PARAM_INT);
	$query->bindParam(':jeu_page',$jeu_page,PDO::PARAM_INT);
	$query->execute();
	return $query;		
}

//Fonction pour compter le nombre total de ligne d'une table
function recup_lign($id_type_jeu)
{
	require("connect_bdd.php");
	$sql = "SELECT COUNT(*)
			FROM  jeu
			WHERE id_type_jeu = :id_type_jeu AND statut_jeu = 1";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
	$query->execute();
	$data=$query->fetchColumn();
	return $data;
}

//Fonction pour récupérer les données d'un seul jeux (page complete_jeu et edit_jeu)
function recup_jeu($id_jeu)
{
	require("connect_bdd.php");
	$sql="	SELECT *
			FROM  jeu
			WHERE id_jeu=:id_jeu";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_STR);
	$query->execute();
	return $query;		
}

//Fonction pour récupérer les données d'un seul jeux (page complete_jeu et edit_jeu)
function recup_id_jeu($title_jeu)
{
    require("connect_bdd.php");
    $sql="	SELECT id_jeu, image_jeu
			FROM  jeu
			WHERE title_jeu=:title_jeu";
    $query=$connect->prepare($sql);
    $query->bindParam(':title_jeu',$title_jeu,PDO::PARAM_STR);
    $query->execute();
    return $query;
}

//Fonction pour récupérer tout les titres des jeux
function recup_title_jeu()
{
	require("connect_bdd.php");
	$sql="SELECT title_jeu
          FROM jeu
          ORDER BY id_type_jeu;";
	$query=$connect->prepare($sql);
	$query->execute();
	return $query;
}

//Fonction pour ajouter un jeu (edit_jeu)
function create_jeu($title_jeu, $text_jeu, $path_image, $id_type_jeu)
{
    require("connect_bdd.php");
    $id=$_SESSION['id_user'];
    var_dump($_SESSION,$id,$title_jeu,$text_jeu,$path_image,$id_type_jeu);

    echo
    $sql = "  INSERT INTO jeu (  title_jeu,  text_jeu,  image_jeu, date_update,  id_type_jeu,   id_user)
              VALUE           ( :title_jeu, :text_jeu, :image_jeu, NOW(),       :id_type_jeu , :id_user)";
    $query=$connect->prepare($sql);
    $query->bindParam(':title_jeu',$title_jeu,PDO::PARAM_STR,50);
    $query->bindParam(':text_jeu',$text_jeu,PDO::PARAM_STR);
    $query->bindParam(':image_jeu',$path_image,PDO::PARAM_STR,200);
    $query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
    $query->bindParam(':id_user',$id,PDO::PARAM_INT);
    $query->execute();
}

//Fonction pour modifier un jeu (edit_jeu)

//Fonction pour supprimer un jeu (page complete_jeu et liste_jeu)
?>