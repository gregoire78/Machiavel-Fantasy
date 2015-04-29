<?php
//Fonction pour récupérer les événements passer ou à avenir
function recup_event($condition)
{
	if($condition==">=")
	{
		$order = "ASC";
	}
	else
	{
		$order = "DESC";
	}
	require("connect_bdd.php");
	$sql="	SELECT id_event, title_event, text_event, date_event, statut_event, date_update, image_event, id_user, id_jeu
			FROM event
			WHERE date_event".$condition."SYSDATE() AND statut_event=1
			ORDER BY date_event ".$order."";
	$query=$connect->prepare($sql);
	$query->execute();
	return $query;
}

//Fonction pour récupérer les données d'un évènement à venir
function recup_event_one($id_event)
{
	require("connect_bdd.php");
	$sql="	SELECT title_event, text_event, date_event, date_update, id_user, id_jeu, image_event
			FROM event
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
function create_event($title_event, $text_event, $date_event, $title_jeu, $image_event)
{
	require("connect_bdd.php");
	$id_user = $_SESSION['id_user'];
	if(empty($image_event))
	{
        if($title_jeu=="Autre")
        {
            $id_jeu = 0;
            $image_event = "images/icone_site/calendrier.jpg";
        }
        else
        {
            $query = recup_id_jeu($title_jeu);
            $data=$query->fetch(PDO::FETCH_ASSOC);
            $image_event = $data['image_jeu'];
            $id_jeu = $data['id_jeu'];
        }
	}

	$sql="INSERT INTO event		( title_event,  image_event,  id_jeu, date_event,  text_event, date_update, id_user )
		  VALUES 				(:title_event, :image_event, :id_jeu,:date_event, :text_event, NOW(),:id_user);";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_event',$title_event,PDO::PARAM_STR,50);
    $query->bindParam(':image_event',$image_event,PDO::PARAM_STR);
	$query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
	$query->bindParam(':date_event',$date_event,PDO::PARAM_STR);
	$query->bindParam(':text_event',$text_event,PDO::PARAM_STR);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour un événement
function update_event($id_event, $title_event, $text_event, $date_event, $title_jeu, $image_event)
{
	require("connect_bdd.php");
    if(empty($image_event))
    {
        if($title_jeu=="Autre")
        {
            $id_jeu = 0;
            $image_event = "images/icone_site/calendrier.jpg";
        }
        else
        {
            $query = recup_id_jeu($title_jeu);
            $data=$query->fetch(PDO::FETCH_ASSOC);
            $image_event = $data['image_jeu'];
            $id_jeu = $data['id_jeu'];
        }
	}
	$sql="	UPDATE event 
			SET title_event = :title_event,
				image_event = :image_event,
				id_jeu      = :id_jeu,
				date_event  = :date_event,
				text_event  = :text_event,
				date_update = NOW()
			WHERE id_event=:id_event";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':title_event',$title_event,PDO::PARAM_STR,50);
    $query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
	$query->bindParam(':date_event',$date_event,PDO::PARAM_STR);
	$query->bindParam(':image_event',$image_event,PDO::PARAM_STR);
	$query->bindParam(':text_event',$text_event,PDO::PARAM_STR);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();
}
?>