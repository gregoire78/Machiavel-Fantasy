<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('accessoires/functions_connect.php');
auto_connexion('profil.php',NULL,NULL);

include_once('accessoires/menu.php');

require("accessoires/connect_bdd.php");
include_once("accessoires/functions_user.php");
include_once("accessoires/functions_historique.php");

if(isset($_GET['pseudo']) && isset($_GET['key']))
{
    //Récupération des variables nécessaires à l'activation
    $key_user = $_GET['key'];
    $pseudo = $_GET['pseudo'];
    //vérifions si activé
    $sql="SELECT activation,key_user FROM users WHERE pseudo= :pseudo_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':pseudo_user',$pseudo,PDO::PARAM_STR);
    $query->execute();
    $info_user=$query->fetch(PDO::FETCH_ASSOC);
    $actif = $info_user["activation"];
    $key = $info_user["key_user"];
    //On teste la valeur de la variable $actif récupéré dans la BDD
    if($actif ==1)
    {
        $errors[1] = "Votre compte est déjà activé";
    }
    else if($actif==0 && $key_user==$key)
    {
        $new_key = md5(microtime(TRUE)*100000);
        $sql="UPDATE users SET activation= 1 , key_user= :new_key WHERE key_user= :key_user AND activation= 0";
        $query=$connect->prepare($sql);
        $query->bindParam(':key_user',$key_user,PDO::PARAM_STR,100);
        $query->bindParam(':new_key',$new_key,PDO::PARAM_STR,100);
        $query->execute();
        $success = "Votre compte est activé, vous pouvez <a class='alert-link' href='connexion.php'>vous connecter</a>.";

        $query = recup_one_user(NULL, $pseudo_user);
        $data=$query->fetch(PDO::FETCH_ASSOC);
        $id_user = $data['id_user'];

        $table_historique = 5;
        create_historique($table_historique, "L'utilisateur a activé son compte", $id_user);
    }
    else
    {
        $errors[2] = "<strong>Erreur !</strong> Votre compte ne peut être activé...";
    }
    header ("Refresh: 5;URL=connexion.php");
}
else
{
    header('location:/');
}
include_once('activation.html');