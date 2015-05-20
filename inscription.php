<?php
/**
 * Créer par: Grégoire JONCOUR
 * Date: 27/03/2015
 * Projet : machiavel
 **/
session_start();
session_regenerate_id();

//l'auto connexion
include_once('accessoires/functions_connect.php');
auto_connexion('profil.php',NULL,NULL);

//fonctions
include_once('accessoires/menu.php');
include_once("accessoires/functions_user.php");
include_once("accessoires/functions_historique.php");

//si il existe post register cad si on clique sur le bouton submit name=register
if(isset($_POST['valider']))
{
    $email_user = htmlentities(trim($_POST["email_user"]));
    if(verif_existe('id_user','users','email',$email_user)!=0)
    {
        header('Location:connexion.php');
    }
}
//si on clique sur le l'inscription
if(isset($_POST["register"]))
{
    //trim supprime les espaces avant et apres la chaine
    $pseudo_user = htmlentities(trim($_POST["pseudo_user"]));
    $lastname_user = htmlentities(ucfirst(trim($_POST["lastname_user"])));
    $firstname_user = htmlentities(ucfirst(trim($_POST["firstname_user"])));
    $civility_user = $_POST["civility"];
    $pw_user = htmlentities($_POST["password_user"]);
    $conf_pw_user = htmlentities($_POST["repeat_password"]);
    $email_user = htmlentities(trim($_POST["email_user"]));
    $captcha = htmlentities(trim($_POST["captcha"]));

    // Génération aléatoire d'une clé
    $key = md5(microtime(TRUE) * 100000);

    $string=35; //taille de la chaine caractères accepté
    /********************** Vérifications pour le nom d'utilisateur ************************/
    if(empty($pseudo_user))
    {
        $errors[1] = "Veuillez saisir un nom d'utlisateur";
    }
    else if(mb_strlen(html_entity_decode($pseudo_user),'utf-8') >= $string)
    {
        $errors[1] = "Votre pseudo ne doit pas dépasser <b>".$string." caractères</b>";
    }
    //vérifions s'il ya des caracteres speciaux dans le champs pseudo
    else if(preg_match('/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ_]/',html_entity_decode($pseudo_user)))
    {
        $errors[1] = "Veuillez n'insérer que des lettres ou chiffres dans votre pseudo.";
    }
    //vérifions si le pseudo éxiste
    else if(verif_existe('id_user','users','pseudo',$pseudo_user)!=0)
    {
        $errors[1] = "Le pseudo <b><i>".$pseudo_user."</i></b> n'est pas disponible";
    }
    /******************************** Vérifications pour le nom ****************************/
    if(empty($lastname_user))
    {
        $errors[2] = "Veuillez saisir votre nom";
    }
    else if(strlen(html_entity_decode($lastname_user)) >= $string)
    {
        $errors[2] = "Votre nom ne doit pas dépasser <b>".$string." caractères</b>";
    }
    else if(preg_match('/[^A-Za-zàâçéèêëîïôûùüÿñæœ ]/',html_entity_decode($lastname_user)))
    {
        $errors[2] = "Veuillez n'insérer que des lettres dans votre nom.";
    }
    /****************************** Vérifications pour le prénom ****************************/
    if(empty($firstname_user))
    {
        $errors[3] = "Veuillez saisir votre prénom";
    }
    else if(strlen(html_entity_decode($firstname_user)) >= $string)
    {
        $errors[3] = "Votre prénom ne doit pas dépasser <b>".$string." caractères</b>";
    }
    else if(preg_match('/[^A-Za-zàâçéèêëîïôûùüÿñæœ ]/', html_entity_decode($firstname_user)))
    {
        $errors[3] = "Veuillez n'insérer que des lettres dans votre prénom.";
    }
    /************************** Vérifications pour le mot de passe *************************/
    if(empty($pw_user))
    {
        $errors[4] = "Veuillez saisir votre mot de passe";
    }
    else if(!preg_match('/[a-z]/',$pw_user) || !preg_match('/[A-Z]/',$pw_user) || !preg_match('/[0-9]/',$pw_user) || strlen($pw_user)<8)
    {
        $errors[4] = "Saisir une Majuscule, un nombre et 8 caractères minium !";
    }

    if(empty($conf_pw_user))
    {
        $errors[5] = "Veuillez confirmer votre mot de passe";
    }
    //verifions si les mots de passes sont identiques
    else if(!empty($pw_user) && $pw_user != $conf_pw_user)
    {
        $errors[5] = "Vos deux mots de passe ne sont pas identiques";
    }
    /****************************** Vérifications pour l'email *****************************/
    if(empty($email_user))
    {
        $errors[6] = "Veuillez saisir votre e-mail";
    }
    //verifions l'email est valide
    else if (!filter_var($email_user, FILTER_VALIDATE_EMAIL))
    {
        $errors[6] = "Ceci n'est pas une adresse mail valide";
    }
    //verifions si l'email existe
    else if(verif_existe('id_user','users','email',$email_user)!=0)
    {
        $errors[6] = "L'adresse <b><i>".$email_user."</i></b> éxiste déjà";
    }
    /****************************** Vérifications pour le captcha **************************/
    if(empty($captcha))
    {
        $errors[8] = "Veuillez saisir le captcha";
    }
    else if($captcha != $_SESSION["rand"])
    {
        $errors[8] = "Le captcha est incorrect";
    }
    /****************************** Si il n'y a aucune erreur(s) ***************************/
    if(empty($errors))
    {
        insertion_user($pseudo_user,$civility_user,$lastname_user,$firstname_user,$pw_user,$email_user,$key);

        $query = recup_one_user(NULL, $pseudo_user);
        $data=$query->fetch(PDO::FETCH_ASSOC);
        $id_user = $data['id_user'];

        $table_historique = 5;
        create_historique($table_historique, "L'utilisateur s'est inscrit", $id_user);

        include_once("accessoires/mail_confirmation_inscription.php");
        session_unset();
        $success = true;
        header('Refresh: 5;URL=index.php');
    }
}

//insertion dans les values
$value_pseudo = (isset($pseudo_user)) ? $pseudo_user:'';
$value_lastname = (isset($lastname_user)) ? $lastname_user:'';
$value_firstname = (isset($firstname_user)) ? $firstname_user:'';
$value_email = (isset($email_user)) ? $email_user:'';

include_once "inscription.html";
