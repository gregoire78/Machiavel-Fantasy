<?php
/**************************** TABLE TOPIC ET TOPIC_WATCH ***************************/
//Fonction pour créer nouveau un topic
function create_topic($title_topic, $text_post, $id_forum)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	
	//On créer un nouveau topic
	$sql="INSERT INTO topic		( title_topic,  id_forum,  id_user, date_update)
		  VALUES 				(:title_topic, :id_forum, :id_user, NOW() );";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_topic',$title_event,PDO::PARAM_STR,50);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
	
	//On récupère le dernier topic créer la l'utilisateur
	$query = recup_topic_user();
	$data=$query->fetch(PDO::FETCH_ASSOC);
	$id_topic = $data['id_topic'];
	
	//On créer un nouveau post avec les données du dernier topic
	create_post($id_topic, $title_topic, $text_post, $id_forum)
	
	//On met à jour le dernier post dans le forum parent
	last_message($id_forum);
}

//Fonction pour récupérer tous les topic d'un forum
function recup_topic_forum($id_forum)
{
	require("connect_bdd.php");
	
	$sql = "SELECT id_topic, title_topic, view_topic, date_update
			FROM topic
			WHERE 	id_forum = :id_forum
			ORDER BY date_update DESC";		
	$query=$connect->prepare($sql);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->execute();
	return $query;	
}

//Fonction pour récuprérer les topics de l'utilisateur
function recup_topic_user()
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	
	$sql = "SELECT id_topic
			FROM topic
			WHERE 	id_user = :id_user
			ORDER BY date_update DESC";		
	$query=$connect->prepare($sql);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
	return $query;
}

//Fonction pour récupérer tous les posts d'un topic
function recup_post_forum($id_topic)
{
	require("connect_bdd.php");
	
	$sql = "SELECT id_forum, title_post, text_post, date_update, id_user
			FROM post
			WHERE 	id_topic = :id_topic
			ORDER BY date_update";		
	$query=$connect->prepare($sql);
	$query->bindParam(':id_topic',$id_topic,PDO::PARAM_INT);
	$query->execute();
	return $query;		
}

//Fonction pour récupérer le post d'un utilisateur
function recup_post($id_post)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	$sql = "SELECT id_forum, id_forum, title_post, text_post, date_update
			FROM post
			WHERE 	id_post = :id_post AND id_user = :id_user";		
	$query=$connect->prepare($sql);
	$query->bindParam(':id_post',$id_post,PDO::PARAM_INT);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
	return $query;	
}

//Fonction pour écrire dans un topic existant
function create_post($id_topic, $title_post, $text_post, $id_forum)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	
	$sql="INSERT INTO post		( id_topic,  title_post,  text_post,  id_forum,  id_user, date_create, date_update)
		  VALUES 				(:id_topic, :title_post, :text_post, :id_forum, :id_user, NOW(), 	   NOW() );";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_post',$title_post,PDO::PARAM_STR,50);
	$query->bindParam(':text_post',$text_post,PDO::PARAM_STR);
	$query->bindParam(':id_forum',$id_forum,PDO::PARAM_INT);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->bindParam(':id_topic',$id_topic,PDO::PARAM_INT);
	$query->execute();
	last_message($id_forum);//On met à jour le dernier topic créer dans le forum parent
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
?>