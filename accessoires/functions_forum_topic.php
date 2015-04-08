<?php
/**************************** TABLE TOPIC ET TOPIC_WATCH ***************************/
//Fonction pour créer nouveau un topic
function create_new_topic($title_topic, $text_topic, $id_forum)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	
	$sql="INSERT INTO topic		( title_topic,  text_topic,  id_forum,  id_user, date_create, date_update)
		  VALUES 				(:title_topic, :text_topic, :id_forum, :id_user, NOW(), NOW() );";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_topic',$title_event,PDO::PARAM_STR,50);
	$query->bindParam(':text_topic',$text_jeu,PDO::PARAM_STR);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
	last_message($id_forum);
}

//Fonction pour écrire dans un topic existant
function create_topic ($id_parent, $title_topic, $text_topic, $id_forum)
{
	$sql="INSERT INTO topic		( id_parent,  title_topic,  text_topic,  id_forum,  id_user, date_create, date_update)
		  VALUES 				(:id_parent, :title_topic, :text_topic, :id_forum, :id_user, NOW(), 	  NOW() );";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_topic',$title_topic,PDO::PARAM_STR,50);
	$query->bindParam(':text_topic',$text_topic,PDO::PARAM_STR);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->bindParam(':id_parent',$id_parent,PDO::PARAM_INT);
	$query->execute();
	last_message($id_forum);
}

//Fonction pour modifier un topic
function update_topic($title_topic, $text_topic, $id_topic)
{
	require("connect_bdd.php");	
	$sql="	UPDATE topic 
			SET title_topic = :title_topic,
				text_topic  = :text_topic,
				date_update =  NOW()
			WHERE id_topic=:id_topic";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':title_topic',$title_topic,PDO::PARAM_STR,50);
	$query->bindParam(':text_topic',$text_topic,PDO::PARAM_STR);
	$query->bindParam(':id_topic',$id_topic,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour supprimer un topic
function delete_topic($id_topic)
{
	require("connect_bdd.php");	
	$sql="	UPDATE topic
			SET statut_topic = 0
			WHERE id_topic=:id_topic";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':id_topic',$id_topic,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour le nombre de vu total d'un topic
function update_total_view($id_topic)
{
	require("connect_bdd.php");	
	$sql="	UPDATE topic
			SET view_topic = (SELECT COUNT(id_user) FROM topic_watch WHERE id_topic = :id_topic)
			WHERE id_topic = :id_topic";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':id_topic',$id_topic,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour la vu d'un topic par un utilisateur
function update_view($id_topic)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	
	$sql="INSERT INTO topic_watch		( id_user,  id_topic)
		  VALUES 						(:id_user, :id_topic);";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->bindParam(':id_topic',$id_topic,PDO::PARAM_INT);
	$query->execute();
}

/************************* TABLE FORUM ET FORUM_ACCESS ********************************/
//Fonction pour créer un forum
function create_forum($id_parent, $title_forum, $text_forum)
{
	require("connect_bdd.php");

	$sql="INSERT INTO forum		( title_forum,  text_forum,  id_parent, date_create, date_update)
		  VALUES 				(:title_forum, :text_forum, :id_forum, NOW(), NOW() );";
	$query->bindParam(':title_forum',$title_forum,PDO::PARAM_STR, 50);
	$query->bindParam(':id_parent',$id_parent,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour un forum
function update_forum($id_forum, $title_forum, $text_forum)
{
	require("connect_bdd.php");	
	$sql="	UPDATE forum 
			SET title_forum = :title_forum,
				text_forum  = :text_forum,
				date_update =  NOW()
			WHERE id_topic=:id_topic";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':title_topic',$title_forum,PDO::PARAM_STR,50);
	$query->bindParam(':text_topic',$text_forum,PDO::PARAM_STR);
	$query->bindParam(':id_topic',$id_forum,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour le dernier message poster d'un forum
function last_message($id_forum)
{
	require("connect_bdd.php");	
	$sql="	UPDATE forum 
			SET id_last_message = (SELECT id_topic FROM topic ORDER BY date_update LIMIT 1)
				text_forum  = :text_forum
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