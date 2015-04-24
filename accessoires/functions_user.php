<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 23/04/2015
 * Time: 22:19
 */

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

//Fonction pour récupéré un utilisateur
function recup_one_user($id_user)
{
    require("connect_bdd.php");
    $sql="SELECT pseudo, civility, lastname, firstname, email, date_register, avatars, droits, messages_users
          FROM users
          WHERE id_user=:id_user AND activation=1;";
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query=$connect->prepare($sql);
    $query->execute();
    return $query;
}

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