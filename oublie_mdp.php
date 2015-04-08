<?php
session_start();

//on verifie si il est deja connecté
$redirin = 'profil';
include_once('accessoires/auto_connexion.php');
//inclure le fichier des fonctions
include_once('accessoires/functions_connect.php');
if(isset($_POST['envoyer']))
{
    $email_user = htmlentities(trim($_POST["email_user"]));
    $captcha = htmlentities(trim($_POST["captcha"]));
    if(empty($email_user))
    {
        $errors[1] = "Veuillez saisir votre e-mail";
    }
    if(empty($captcha))
    {
        $errors[4] = "Veuillez remplir le captcha";
    }
    //verifions l'email est valide
    if (!filter_var($email_user, FILTER_VALIDATE_EMAIL))
    {
        $errors[2] = "Ceci n'est pas une adresse mail valide";
    }
    //verifions le captcha
    if($captcha != $_SESSION["rand"] && !isset($errors[4]))
    {
        $errors[5] = "Le captcha est incorrect";
    }
    //verifions si l'email existe
    if(verif_existe('email',$email_user)!=1)
    {
        $errors[3] = "Cet adresse n'éxiste pas";
    }

    if(empty($errors))
    {
        //création nouveau code alpha numérique
        $rand = sha1(rand());
        $random = rand( 6 , 10 );
        $randmdp = substr($rand,0,$random);
        $salt = "802587@!alsd";
        $newmdp = sha1(sha1($randmdp).$salt);
        $sql="UPDATE users SET password = :password WHERE email= :email";
        $query=$connect->prepare($sql);
        $query->bindParam(':password',$newmdp,PDO::PARAM_STR);
        $query->bindParam(':email',$email_user,PDO::PARAM_STR);
        $query->execute();
        include_once("accessoires/mail_newmdp.php");
        $page_ok = true;
        session_unset();
        header("Refresh: 5;URL=connexion.php");
    }
}

include_once("oublie_mdp.html");