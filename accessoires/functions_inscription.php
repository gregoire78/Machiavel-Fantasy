<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 01/05/2015
 * Time: 16:47
 */

//Fontion pour s'inscrire à un événement
function inscription_event($id_event)
{
    require("connect_bdd.php");
    $id_user = $_SESSION['id_user'];
    $sql="INSERT INTO inscription	  ( id_event, id_user, date_inscription )
		  VALUES 				      (:id_event, :id_user, NOW() );";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->execute();
    nb_incrit($id_event);
}

//Fonction pour mettre à jour le nombre de personne inscrit à un événement
function nb_incrit($id_event)
{
    require("connect_bdd.php");
    $sql="UPDATE event
          SET
              nb_inscrit = (SELECT COUNT(*) FROM inscription WHERE id_event=:id_event)
          WHERE id_event = :id_event ";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->execute();
}
//Fonction pour désinscrire la dernière perssonne enregistrer
function desinscription_last_user($id_event)
{
    require("connect_bdd.php");
    $sql="SELECT id_user
          FROM inscription
          WHERE date_inscription = (SELECT MAX(date_inscription) FROM inscription WHERE id_event = :id_event) AND id_event = :id_event";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch(PDO::FETCH_ASSOC);
    $id_user = $data['id_user'];
    desinscription_event($id_event, $id_user);
}

//Fonction pour désinscrire toute les personnes inscrites à un événement
function desinscription_event($id_event)
{
    require("connect_bdd.php");
    $sql="DELETE FROM inscription
          WHERE id_event = :id_event";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->execute();
}

//Fonction pour se désinscrire d'un événement
function desinscription_user_event($id_event, $id_user)
{
    require("connect_bdd.php");
    $sql="DELETE FROM inscription
          WHERE id_user = :id_user AND id_event = :id_event";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->execute();
    nb_incrit($id_event);
}

//Fonction pour savoir si on ne dépasse pas le nombre d'inscription
function verif_inscription($id_event, $condition)
{
    require("connect_bdd.php");
    $sql="  SELECT COUNT(*)
            FROM event
            WHERE inscription_event ".$condition." nb_inscrit AND id_event = :id_event";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch(PDO::FETCH_ASSOC);
    return $data['COUNT(*)'];
}

//Fonction pour récupérer les utilisateur inscrit à un événement
function recup_inscrit($id_event)
{
    require("connect_bdd.php");
    $sql="SELECT i.id_user, pseudo, avatars
          FROM inscription i

          JOIN users u
          ON u.id_user=i.id_user

          WHERE id_event = :id_event
          ORDER BY date_inscription;";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->execute();
    return $query;
}

//Fontion pour savoir si un utilisateur s'est déjà inscrit à un événement
function recup_user_inscrit($id_event, $id_user)
{
    require("connect_bdd.php");
    $sql="SELECT COUNT(*)
          FROM inscription

          WHERE id_event = :id_event AND id_user = :id_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_event',$id_event,PDO::PARAM_INT);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch(PDO::FETCH_ASSOC);
    $nb = $data['COUNT(*)'];
    return $nb;
}
?>