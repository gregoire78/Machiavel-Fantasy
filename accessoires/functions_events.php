<?php
//Fonction pour récupérer les événements passer ou à avenir
function recup_event($condition, $id_user, $page, $event_page, $tri, $ordre)
{
    $nb_event = ($page-1)*$event_page;
	require("connect_bdd.php");
	$sql="	SELECT id_event AS id_event_bis, title_event, text_event, date_event, statut_event, date_update, image_event, id_user, id_jeu AS id_jeu_bis, inscription_event, nb_inscrit,

            CASE id_jeu
            WHEN 0 THEN NULL
            ELSE (SELECT title_jeu FROM jeu WHERE id_jeu =  id_jeu_bis)
            END title_jeu,

            CASE :id_user_bis
            WHEN 0 THEN 0
            ELSE (SELECT COUNT(*) FROM inscription WHERE id_event =id_event_bis AND id_user =:id_user_bis)
            END verif

            FROM event

			WHERE date_event ".$condition." SYSDATE() AND statut_event=1
			ORDER BY "."$tri"." ".$ordre."
			LIMIT   :nb_event, :event_page";
	$query=$connect->prepare($sql);
    $query->bindParam(':id_user_bis',$id_user,PDO::PARAM_INT);
    $query->bindParam(':nb_event',$nb_event,PDO::PARAM_INT);
    $query->bindParam(':event_page',$event_page,PDO::PARAM_INT);
	$query->execute();
	return $query;
}

//Fonction pour compter le nombre total de ligne d'une table
function recup_lign_event($condition)
{
    require("connect_bdd.php");
    $sql = "SELECT COUNT(*)
			FROM  event
			WHERE date_event ".$condition." SYSDATE() AND statut_event=1";
    $query=$connect->prepare($sql);
    $query->execute();
    $data=$query->fetchColumn();
    return $data;
}

//Fonction pour récupérer les données d'un évènement à venir
function recup_event_one($id_event)
{
	require("connect_bdd.php");
	$sql="	SELECT title_event, text_event, date_event, date_update, id_user, id_jeu, image_event, inscription_event
			FROM event
			WHERE id_event=:id_event AND statut_event=1 AND date_event > SYSDATE()";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();
	return $query;	
}

//Fonction pour récupérer les données du dernier événement crée par l'utilisateur
function recup_last_event()
{
    require("connect_bdd.php");
    $id_user = $_SESSION['id_user'];
    $sql="	SELECT id_event, title_event, text_event, date_event, date_update, id_jeu, image_event, inscription_event
			FROM event
			WHERE id_user=:id_user
            ORDER BY date_update DESC
            LIMIT 1";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->execute();
    return $query;
}

//Fonction pour supprimer un évènement
function delete_event($id_event)
{
	require("connect_bdd.php");
	$sql="  DELETE FROM event
            WHERE id_event=:id_event;";
	$query=$connect->prepare($sql);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour créer un événement
function create_event($title_event, $text_event, $date_event, $title_jeu, $image_event, $inscription_event)
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

	$sql="INSERT INTO event		( title_event,  image_event,  id_jeu, date_event,  text_event, date_update, id_user, inscription_event)
		  VALUES 				(:title_event, :image_event, :id_jeu,:date_event, :text_event, NOW(),:id_user, :inscription_event);";
	$query=$connect->prepare($sql);
	$query->bindParam(':title_event',$title_event,PDO::PARAM_STR,50);
    $query->bindParam(':image_event',$image_event,PDO::PARAM_STR);
	$query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
    $query->bindParam(':inscription_event',$inscription_event,PDO::PARAM_INT);
	$query->bindParam(':date_event',$date_event,PDO::PARAM_STR);
	$query->bindParam(':text_event',$text_event,PDO::PARAM_STR);
	$query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
	$query->execute();
}

//Fonction pour mettre à jour un événement
function update_event($id_event, $title_event, $text_event, $date_event, $title_jeu, $image_event, $inscription_event)
{
	require("connect_bdd.php");
    require("functions_inscription.php");
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
				date_update = NOW(),
				inscription_event = :inscription_event
			WHERE id_event=:id_event";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':title_event',$title_event,PDO::PARAM_STR,50);
    $query->bindParam(':inscription_event',$inscription_event,PDO::PARAM_INT);
    $query->bindParam(':id_jeu',$id_jeu,PDO::PARAM_INT);
	$query->bindParam(':date_event',$date_event,PDO::PARAM_STR);
	$query->bindParam(':image_event',$image_event,PDO::PARAM_STR);
	$query->bindParam(':text_event',$text_event,PDO::PARAM_STR);
	$query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
	$query->execute();


    while ($verif = verif_inscription($id_event, "<"))
    {
        desinscription_last_user($id_event);
    }
}
?>