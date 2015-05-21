<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('accessoires/functions_connect.php');
auto_connexion('profil.php',NULL,NULL);

//fonctions
include_once('accessoires/menu.php');

if(isset($_GET['pseudo']) && isset($_GET['key']))
{
    $data = recup_data_user(array("key_user" => $_GET['key'] , "id_user" => $_GET['pseudo']),'newmdverif');

    if($data['count(id_user)'] == 1)
    {
        $affiche_form = true;
        if(isset($_POST['modifierPassword']))
        {
            include_once("accessoires/functions_historique.php");
            $password_new = htmlentities($_POST['NewPassword']);
            $password_new_repeat = htmlentities($_POST['ConfNewPassword']);

            if(empty($password_new))
            {
                $errors_mdp[2] = "Veuillez saisir un nouveau mot de passe";
            }
            else
            {
                if(!preg_match('/[a-z]/',$password_new) || !preg_match('/[A-Z]/',$password_new) || !preg_match('/[0-9]/',$password_new) || strlen($password_new)<8)
                {
                    $errors_mdp[2] = "Saisir une Majuscule, un nombre et 8 caractères minimum !";
                }
                else
                {
                    if($password_new != $password_new_repeat)
                    {
                        $errors_mdp[3] = "Les deux mots de passe ne sont pas identiques";
                    }
                    else
                    {
                        $success=update_password($password_new,$_GET['pseudo']);
                        $table_historique = 5;
                        create_historique($table_historique, "Modification du mot de passe (oublie du mot de passe)", $_GET['pseudo']);

                        header('Refresh: 2;URL=connexion.php');
                    }
                }
            }
        }
    }
    else
    {
        $affiche_form = false;
    }
}

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
    if(verif_existe('id_user','users','email',$email_user)!=1)
    {
        $errors[3] = "Cette adresse n'éxiste pas";
    }

    if(empty($errors))
    {
        $data = recup_data_user(array("email" => $email_user),"newmdp");
        $id_user = $data['id_user'];
        $key = $data['key_user'];
        include_once("accessoires/mail_newmdp.php");
        $page_ok = true;
        session_unset();
        header("Refresh: 5;URL=connexion.php");
    }
}

include_once("oublie_mdp.html");