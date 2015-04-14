<?php
/************************* TABLE FORUM ET FORUM_ACCESS ********************************/
//Fonction pour créer un forum
function create_forum($title_forum, $text_forum, $id_parent, $lien_forum, $type_forum)
{
	require("connect_bdd.php");

	$sql="INSERT INTO forum		( title_forum,  text_forum,  id_parent,  lien_forum,  type_forum, date_update)
		  VALUES 				(:title_forum, :text_forum, :id_parent, :lien_forum, :type_forum, NOW() );";
	$query->bindParam(':title_forum',$title_forum,PDO::PARAM_STR, 255);
	$query->bindParam(':text_forum',$text_forum,PDO::PARAM_STR, 255);
	$query->bindParam(':id_parent',$id_parent,PDO::PARAM_INT);
	$query->bindParam(':lien_forum',$lien_forum,PDO::PARAM_STR,255);
	$query->bindParam(':type_forum',$type_forum,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour un forum
function update_forum($id_forum, $title_forum, $text_forum, $id_parent, $lien_forum, $type_forum)
{
	require("connect_bdd.php");	
	$sql="	UPDATE forum 
			SET title_forum = :title_forum,
				text_forum  = :text_forum,
				id_parent   = :id_parent,
				lien_forum  = :lien_forum,
				type_forum  = :type_forum,
				date_update =  NOW()
			WHERE id_forum=:id_forum";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':title_forum',$title_forum,PDO::PARAM_STR, 255);
	$query->bindParam(':text_forum',$text_forum,PDO::PARAM_STR, 255);
	$query->bindParam(':id_parent',$id_parent,PDO::PARAM_INT);
	$query->bindParam(':lien_forum',$lien_forum,PDO::PARAM_STR,255);
	$query->bindParam(':type_forum',$type_forum,PDO::PARAM_INT);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour le dernier message poster d'un forum
function last_message($id_forum)
{
	require("connect_bdd.php");	
	$sql="	UPDATE forum 
			SET id_last_message = (SELECT id_post FROM post WHERE id_forum = :id_forum ORDER BY date_update DESC LIMIT 1)
			WHERE id_forum=:id_forum";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour le statut d'un forum (0 = supprimer ; 1 = visible ; 2 = privé)
function statut_forum($id_forum, $statut_forum)
{
	require("connect_bdd.php");	
	$sql="	UPDATE forum
			SET statut_forum = :statut_forum
			WHERE id_forum=:id_forum";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':statut_forum',$statut_forum,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour créer un niveau d'accès à un forum pour un utilisateur ($access_forum ; 0 = aucun ; 1 = lecture ; 2 = écriture)
function create_access($id_forum, $id_user, $access_forum)
{
	require("connect_bdd.php");
	
	$sql="INSERT INTO forum_access		( id_forum,  id_user,  access_forum)
		  VALUES 						(:id_forum, :id_user, :access_forum)";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':access_forum',$access_forum,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour un niveau d'accès à un forum pour un utilisateur ($access_forum ; 0 = aucun ; 1 = lecture ; 2 = écriture)
function update_access($id_forum, $id_user, $access_forum)
{
	require("connect_bdd.php");
	
	$sql="	UPDATE forum_access
			SET access_forum = :access_forum
			WHERE id_forum = :id_forum AND id_user = :id_user";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':access_forum',$access_forum,PDO::PARAM_INT);
	$query->execute();
}
?>