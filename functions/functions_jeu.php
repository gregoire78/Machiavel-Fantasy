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

//Fonction pour supprimer une catégorie de jeu
function delete_type_jeu($id_type_jeu)
{
    require("connect_bdd.php");
    $sql = "  DELETE FROM type_jeu
              WHERE id_type_jeu =:id_type_jeu";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
    $query->execute();
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
function recup_liste_jeu($id_type_jeu, $tri, $ordre, $page, $jeu_page, $id_jeu, $statut_jeu)
{
    if((isset($tri) && isset($ordre) && isset($page) && isset($jeu_page)))
    {
        $nb_jeu = ($page - 1) * $jeu_page;
    }

	require("connect_bdd.php");
	$sql="	SELECT id_jeu, title_jeu, text_jeu, image_jeu, date_update, statut_jeu, libelle_type_jeu, color_type_jeu
			FROM   jeu j

			JOIN type_jeu t
			ON j.id_type_jeu = t.id_type_jeu";

    if (isset($id_type_jeu))
    {
        $sql = $sql."
            WHERE  j.id_type_jeu=:id_type_jeu AND statut_jeu = 1";
    }
    else if(isset($id_jeu))
    {
        $sql=$sql."
            WHERE id_jeu = :id_jeu" ;
    }

    if(isset($statut_jeu))
    {
       $sql=$sql."
            WHERE statut_jeu = :statut_jeu" ;
    }

    if((isset($tri) && isset($ordre) && isset($page) && isset($jeu_page)))
    {
        $sql = $sql."
            ORDER BY ".$tri." ".$ordre."
            LIMIT   :nb_jeu, :jeu_page";
    }
	$query=$connect->prepare($sql);
    if (isset($id_type_jeu))
    {
        $query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
    }
    else if(isset($id_jeu))
    {
        $query->bindParam(':id_jeu', $id_jeu, PDO::PARAM_INT);
    }
    if(isset($statut_jeu))
    {
        $query->bindParam(':statut_jeu', $statut_jeu, PDO::PARAM_INT);
    }
    if((isset($tri) && isset($ordre) && isset($page) && isset($jeu_page)))
    {
        $query->bindParam(':nb_jeu', $nb_jeu, PDO::PARAM_INT);
        $query->bindParam(':jeu_page', $jeu_page, PDO::PARAM_INT);
    }
    $query->execute();
	return $query;		
}

//Fonction pour compter le nombre total de ligne d'une table
function recup_lign($id_type_jeu, $statut_jeu)
{
	require("connect_bdd.php");
	$sql = "SELECT COUNT(*)
			FROM  jeu";
    if (isset($id_type_jeu))
    {
        $sql = $sql."
			WHERE id_type_jeu = :id_type_jeu ";
    }

    if(isset($statut_jeu))
    {
        $sql=$sql."
            WHERE statut_jeu = :statut_jeu" ;
    }

	$query=$connect->prepare($sql);
    if(isset($id_type_jeu))
    {
        $query->bindParam(':id_type_jeu',$id_type_jeu,PDO::PARAM_INT);
    }
    if(isset($statut_jeu))
    {
        $query->bindParam(':statut_jeu', $statut_jeu, PDO::PARAM_INT);
    }
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
/**
 * @param $title_jeu
 * @return mixed
 */
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
/**
 * @return array
 */
function recup_title_jeu()
{
	require("connect_bdd.php");
	$sql="SELECT title_jeu, statut_jeu
          FROM jeu
          ORDER BY id_type_jeu;";
	$query=$connect->prepare($sql);
	$query->execute();
	return $query;
}

//Fonction pour ajouter un jeu (edit_jeu)
/**
 * @param $title_jeu
 * @param $text_jeu
 * @param $path_image
 * @param $id_type_jeu
 */
function create_jeu($title_jeu, $text_jeu, $path_image, $id_type_jeu)
{
    require("connect_bdd.php");
    $id=$_SESSION['id_user'];

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
function active_jeu($statut_jeu, $id_jeu)
{
    require("connect_bdd.php");
    $sql="  UPDATE jeu
            SET  statut_jeu =:statut_jeu
            WHERE id_jeu =:id_jeu";
    $query=$connect->prepare($sql);
    $query->bindParam(':statut_jeu',$statut_jeu,PDO::PARAM_INT);
    $query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
    $query->execute();
}

//fonction pour creer un type de jeu
function create_type_jeu($libelle_type_jeu,$description_type_jeu,$color_type_jeu)
{
    require("connect_bdd.php");
    $sql = "  INSERT INTO type_jeu (  libelle_type_jeu, description_type_jeu, color_type_jeu)
              VALUE           (:libelle_type_jeu, :description_type_jeu, :color_type_jeu )";
    $query=$connect->prepare($sql);
    $query->bindParam(':libelle_type_jeu',$libelle_type_jeu,PDO::PARAM_STR,50);
    $query->bindParam(':description_type_jeu',$description_type_jeu,PDO::PARAM_STR,150);
    $query->bindParam(':color_type_jeu',$color_type_jeu,PDO::PARAM_STR,7);
    return $query->execute();
}
?>