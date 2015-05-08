<?php
session_start();
session_regenerate_id();

//l'auto connexion
include_once('accessoires/functions_connect.php');
auto_connexion(NULL,'index.php',0);

//fonctions
include_once('accessoires/menu.php');
include_once("accessoires/functions_historique.php");

//on recupere les données de l'utilisateur
$id_user = (int)$_SESSION['id_user'];
$data = recup_data_user($id_user);
$pseudo_user_data=$_SESSION['pseudo'];
$civility_user_data=$data['civility'];
$lastname_user_data=$data['lastname'];
$firstname_user_data=$data['firstname'];
$email_user_data=$data['email'];
$avatar=$_SESSION['avatars'];

/**************** modif infos de l'utilisateur ********************/
if(isset($_POST['modifier_data']))
{
    //on recupere les valeurs changées
    $pseudo_user_new = trim(htmlentities($_POST['pseudo_user']));
    $civility_user_new = $_POST['civility_user'];
    $lastname_user_new = trim(htmlentities($_POST['lastname_user']));
    $firstname_user_new = trim(htmlentities($_POST['firstname_user']));
    $email_user_new = trim(htmlentities($_POST['email_user']));

    $string=35; //taille de la chaine caractères accepté
    /********************** Vérifications pour le nom d'utilisateur ************************/
    if(empty($pseudo_user_new))
    {
        $error_data[1] = "Veuillez saisir un pseudo";
    }
    else if(mb_strlen(html_entity_decode($pseudo_user_new),'utf-8') >= $string)
    {
        $error_data[1] = "Votre pseudo ne doit pas dépasser <b>".$string." caractères</b>";
    }
    //vérifions s'il ya des caracteres speciaux dans le champs pseudo
    else if(preg_match('/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ_]/',html_entity_decode($pseudo_user_new)))
    {
        $error_data[1] = "Veuillez n'insérer que des lettres ou chiffres dans votre pseudo.";
    }
    //vérifions si le pseudo éxiste
    else if($pseudo_user_new!=$pseudo_user_data && verif_existe('id_user','users','pseudo',$pseudo_user_new)!=0)
    {
        $error_data[1] = "Ce pseudo n'est pas disponible";
    }
    /******************************** Vérifications pour le nom ****************************/
    if(empty($lastname_user_new))
    {
        $error_data[2] = "Veuillez saisir votre nom";
    }
    else if(strlen(html_entity_decode($lastname_user_new)) >= $string)
    {
        $error_data[2] = "Votre nom ne doit pas dépasser <b>".$string." caractères</b>";
    }
    else if(preg_match('/[^A-Za-zàâçéèêëîïôûùüÿñæœ ]/',html_entity_decode($lastname_user_new)))
    {
        $error_data[2] = "Veuillez n'insérer que des lettres dans votre nom.";
    }
    /****************************** Vérifications pour le prénom ****************************/
    if(empty($firstname_user_new))
    {
        $error_data[3] = "Veuillez saisir votre prénom";
    }
    else if(strlen(html_entity_decode($firstname_user_new)) >= $string)
    {
        $error_data[3] = "Votre prénom ne doit pas dépasser <b>".$string." caractères</b>";
    }
    else if(preg_match('/[^A-Za-zàâçéèêëîïôûùüÿñæœ ]/', html_entity_decode($firstname_user_new)))
    {
        $error_data[3] = "Veuillez n'insérer que des lettres dans votre prénom.";
    }
    /****************************** Vérifications pour l'email *****************************/
    if(empty($email_user_new))
    {
        $error_data[4] = "Veuillez saisir votre e-mail";
    }
    //verifions l'email est valide
    else if (!filter_var($email_user_new, FILTER_VALIDATE_EMAIL))
    {
        $error_data[4] = "Ceci n'est pas une adresse mail valide";
    }
    //verifions si l'email existe
    else if($email_user_new!=$email_user_data && verif_existe('id_user','users','email',$email_user_new)!=0)
    {
        $error_data[4] = "L'adresse <b><i>".$email_user_new."</i></b> éxiste déjà";
    }
    /****************************** Si il n'y a aucune erreur(s) ***************************/
    if(empty($error_data))
    {
        update_data_user($pseudo_user_new,$lastname_user_new,$firstname_user_new,$civility_user_new,$email_user_new,$id_user);

        $table_historique = 5;
        create_historique($table_historique, "Modification des informations utilisateur", $_SESSION['id_user']);

        $success_data = true;
        header('Refresh: 2;URL=#');
    }
}
/********************** mot de passe ***************************/
if(isset($_POST['modifierPassword']))
{
    $password_actuel = htmlentities($_POST['passwordActuel']);
    $password_new = htmlentities($_POST['NewPassword']);
    $password_new_repeat = htmlentities($_POST['ConfNewPassword']);

    if(empty($password_actuel))
    {
        $errors_mdp[1] = "Veuillez insérer le mot de passe actuel";
    }
    else
    {
        if(!empty($password_actuel))
        {
            $hash = recup_hash('id_user',$id_user);
            if (!password_verify($password_actuel, $hash))
            {
                $errors_mdp[1] = "Le mot de passe actuel est mauvais";
            }
            else
            {
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
                            $success=update_password($password_new);

                            $table_historique = 5;
                            create_historique($table_historique, "Modification du mot de passe", $_SESSION['id_user']);

                            header('Refresh: 2;URL=#');
                        }
                    }
                }
            }
        }
    }
}
include_once("profil.html");
