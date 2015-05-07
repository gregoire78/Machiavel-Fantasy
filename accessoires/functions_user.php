<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 23/04/2015
 * Time: 22:19
 */

//Fonction pour récupérer le statut d'un utilisateur
function recup_statut()
{
    require("connect_bdd.php");
    $sql="SELECT droits
          FROM users
          WHERE activation=1 AND id_user=:id_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_user',$_SESSION['id_user'],PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch(PDO::FETCH_ASSOC);
    return $data['droits'];
}
//Fonction pour récupérer tous les utilisateurs
function recup_all_user($tri, $ordre)
{
    require("connect_bdd.php");
    $sql="SELECT pseudo, civility, lastname, firstname, email, date_register, avatars, droits, messages_users
          FROM users
          WHERE activation=1
          ORDER BY :ordre :tri;";
    $query->bindParam(':tri',$tri,PDO::PARAM_STR, 4);
    $query->bindParam(':ordre',$ordre,PDO::PARAM_STR, 15 );
    $query=$connect->prepare($sql);
    $query->execute();
    return $query;
}

//Fonction pour récupéré les données d'un utilisateur
function recup_one_user($id_user, $pseudo_user)
{
    require("connect_bdd.php");
    $sql="SELECT id_user, pseudo, civility, lastname, firstname, email, date_register, avatars, droits, messages_users
          FROM users
          WHERE id_user=:id_user OR pseudo=:pseudo_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->bindParam(':pseudo_user',$pseudo_user,PDO::PARAM_INT);
    $query->execute();
    return $query;
}

/*Fonction pour récupérer le dernier utilisateur inscrit
function recup_last_user_inscrit()
{
    require("connect_bdd.php");
    $sql="SELECT pseudo, civility, lastname, firstname, email, date_register, avatars, droits, messages_users
          FROM users
          WHERE id_user=:id_user AND activation=1;";
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query=$connect->prepare($sql);
    $query->execute();
    return $query;
}*/

//Fonction pour mettre à jour le statut d'un utilisateur
function update_statut_user($id_user, $droits)
{
    require("connect_bdd.php");
    $sql = "UPDATE users
            SET droits = :droits
            WHERE id_user=:id_user;";
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->bindParam(':droits',$droits,PDO::PARAM_INT);
    $query=$connect->prepare($sql);
    $query->execute();
    return $query;
}


?>