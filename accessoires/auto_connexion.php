<?php
/************************************************
Script de connexion si utilisateur déjà connecté
 ************************************************/

//connection bdd
include_once('../functions/connect_bdd.php');
include_once('../functions/functions_connect.php');
//pour les cookie c'est a dire si l'utilisateur a choisi de rester connecté
$p=1;
//si l'utilisateur a une session
if(isset($_SESSION['id_user']))
{
    $id_user = $_SESSION['id_user'];
    $sql="SELECT count(id_user) FROM users WHERE id_user= :id_user AND activation=1";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->execute();
    $count_id=$query->fetchColumn();
    //resultat recherche
    if($count_id==1)
    {
        if(isset($redirin) && $redirin=='profil')
        {
            header('location:profil.php');
        }
    }
    else
    {
        header('location:deconnexion.php');
    }
}
else if(isset($_COOKIE["par_log"]) && isset($_COOKIE['id_log']))
{
    $cookieid=$_COOKIE['id_log'];
    $cookiemail=$_COOKIE['par_log'];

    $sql="SELECT id_user,email FROM users";
    $query=$connect->prepare($sql);
    $query->execute();

    while($verif=$query->fetch(PDO::FETCH_ASSOC))
    {
        $mailpart[$p] = $verif['email'];
        $idpart[$p] = $verif['id_user'];
        $cryptidpart[$p] = sha1(sha1($idpart[$p])."4007@!machiavelfantasy");
        $cryptmailpart[$p] = sha1(sha1($mailpart[$p])."4007@!machiavelfantasy");

        if($cryptmailpart[$p]==$cookiemail && $cryptidpart[$p]==$cookieid)
        {
            $id_user = $idpart[$p];
            $mail_user = $mailpart[$p];
            $_SESSION['id_user']=$idpart[$p];
            $sql="SELECT count(id_user) FROM users WHERE id_user= :id_user AND email= :mail_user AND activation=1";
            $query=$connect->prepare($sql);
            $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
            $query->bindParam(':mail_user',$mail_user,PDO::PARAM_INT);
            $query->execute();
            $count_id=$query->fetchColumn();
            //resultat recherche
            if($count_id==1)
            {
                date_last_co($idpart[$p]);
                if(isset($redirin) && $redirin=='profil')
                {
                    header('location:profil.php');
                }

            }
            else
            {
                header('location:deconnexion.php');
            }
        }
    }
    $p++;
}
else
{
    if(isset($redirin) && $redirin=='connexion')
    {
        header('location:index.php');
    }
}