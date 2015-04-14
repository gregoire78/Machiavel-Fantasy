<?php
//Fonction pour récupérer les événements passer ou à avenir
function recup_event($condition)
{
	require("connect_bdd.php");
	$sql="	SELECT id_event, title_event, text_event, date_event, statut_event, e.date_update, e.id_user, pseudo, avatars, e.id_jeu, image_jeu
			FROM event e
			
			JOIN users u
			ON u.id_user = e.id_user
			
			JOIN jeu j
			ON j.id_jeu = e.id_jeu
			
			WHERE date_event".$condition."SYSDATE() AND statut_event=1
			ORDER BY date_event DESC;";
	$query=$connect->prepare($sql);
	$query->execute();
	return $query;
}

//Fonction pour récupérer les données d'un évènement à venir
function recup_event_one($id_event)
{
	require("connect_bdd.php");
	$sql="	SELECT title_event, text_event, date_event, e.date_update, e.id_user, title_jeu
			FROM event e
			
			JOIN jeu j
			ON e.id_jeu = j.id_jeu
			
			WHERE id_event=:id_event AND statut_event=1 AND date_event > SYSDATE()";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();
	return $query;	
}

//Fonction pour supprimer un évènement
function delete_event($id_event)
{
	require("connect_bdd.php");
	$sql="UPDATE event SET statut_event= 0 WHERE id_event=:id_event;";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour créer un événement
function create_event($title_event, $text_event, $date_event, $date_update, $title_jeu)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	
	$sql="INSERT INTO event		(title_event, id_jeu, date_event, text_event, date_update, id_user)
		  VALUES 				(:title_event,(SELECT id_jeu FROM jeu WHERE title_jeu=:title_jeu),:date_event, :text_event, NOW(),:id_user);";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_event',$title_event,PDO::PARAM_STR,50);
	$query->bindParam(':title_jeu',$title_jeu,PDO::PARAM_STR,50);
	$query->bindParam(':date_event',$date_event,PDO::PARAM_STR);
	$query->bindParam(':text_event',$text_event,PDO::PARAM_STR);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour un événement
function update_event($id_event, $title_event, $text_event, $date_event, $date_update, $title_jeu)
{
	require("connect_bdd.php");
	
	$sql="	UPDATE event 
			SET title_event = :title_event,
				id_jeu = (SELECT id_jeu FROM jeu WHERE title_jeu=:title_jeu),
				date_event = :date_event,
				text_event = :text_event,
				date_update = NOW()
			WHERE id_event=:id_event";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':title_event',$title_event,PDO::PARAM_STR,50);
	$query->bindParam(':title_jeu',$title_jeu,PDO::PARAM_STR,50);
	$query->bindParam(':date_event',$date_event,PDO::PARAM_STR);
	$query->bindParam(':text_event',$text_event,PDO::PARAM_STR);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();
}
?>