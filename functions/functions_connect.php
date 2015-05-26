<?php
//fonction qui verifie si l'entité preciser existe
function verif_existe($id,$tab,$col,$email_user)
{
    require('connect_bdd.php');
    $sql="SELECT count(".$id.") FROM ".$tab." WHERE ".$col."= :email_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':email_user',$email_user,PDO::PARAM_STR,35);
    $query->execute();
    $count_entity=$query->fetchColumn();
    return $count_entity;
}
/****************************** nouvelles fonctions *****************************************/
//fonction insérant l'utilisateur dans la bdd
function insertion_user($pseudo_user,$civility_user,$lastname_user,$firstname_user,$pw_user,$email_user,$key)
{
    require("connect_bdd.php");//on inclut la connection à la bdd
    $password = password_hash($pw_user,PASSWORD_BCRYPT);
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO users(pseudo,civility,lastname,firstname,password,email,date_register,date_lastco,ip_user,key_user)
              VALUES (:pseudo_user,:civility,:lastname_user,:firstname_user,:pw_user,:email_user,NOW(),NOW(),:ip,:key);";
    $query=$connect->prepare($sql);
    $query->bindParam(':pseudo_user',$pseudo_user,PDO::PARAM_STR,35);
    $query->bindParam(':civility',$civility_user,PDO::PARAM_STR,4);
    $query->bindParam(':lastname_user',$lastname_user,PDO::PARAM_STR,35);
    $query->bindParam(':firstname_user',$firstname_user,PDO::PARAM_STR,35);
    $query->bindParam(':pw_user',$password,PDO::PARAM_STR, 60);
    $query->bindParam(':email_user',$email_user,PDO::PARAM_STR,320);
    $query->bindParam(':ip',$ip,PDO::PARAM_STR,20);
    $query->bindParam(':key',$key,PDO::PARAM_STR,100);
    $query->execute();
}

//fonction récupérant et verifie le mot de passe suivant l'email
function recup_hash($col,$email)
{
    require("connect_bdd.php");
    $sql = "SELECT password FROM users WHERE ".$col."=:data; ";
    $query=$connect->prepare($sql);
    $query->bindParam(':data',$email,PDO::PARAM_STR,320);
    $query->execute();
    $password = $query->fetchColumn();
    return $password;
}

//fonction qui récupère l'id de l'user pour la connexion
/*function connexion_user($email,$hash)
{
    require("connect_bdd.php");

    $sql = "SELECT pseudo,avatars,id_user,droits,activation FROM users WHERE email= :email AND password= :password";
    $query=$connect->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR,320);
    $query->bindParam(':password',$hash,PDO::PARAM_STR,60);
    $query->execute();
    $data=$query->fetch(PDO::FETCH_ASSOC);
    return $data;
}*/

//fonction parmettant d'auto connecter l'utilisateur à inserer sur toute les pages en relation avec l'utilisateur
function auto_connexion($page_redirection_ok,$page_redirection_nok,$droits)
{
    require("connect_bdd.php");
    include_once("functions_user.php");

    if(isset($_SESSION['id_user']))
    {
        $id_user = $_SESSION['id_user'];
        $sql="SELECT count(id_user) FROM users WHERE id_user= :id_user AND activation=1 AND droits!=0";
        $query=$connect->prepare($sql);
        $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
        $query->execute();
        $count_id=$query->fetchColumn();
        //resultat recherche
        if($count_id==1)
        {
            if(isset($page_redirection_ok))
            {
                header('Location:'.$page_redirection_ok.'');
            }
        }
        else
        {
            header('location:deconnexion.php');
        }

        //si il reste connecter trop longtemps s'en s'enregistrer
        if(isset($_SESSION['timestamp']))
        {
            if($_SESSION['timestamp'] + 60*60 > time())
            {
                $_SESSION['timestamp'] = time();
            }
            else
            {
                header('Location:deconnexion.php');
            }
        }

        //si il y a une restriction de droit

        if(isset($droits))
        {
            $droitsData=recup_statut();
            if($droitsData<$droits)
            {
                header('Location:/index.php');
            }
        }
    }
    else if(isset($_COOKIE['auth']))
    {
        $i=1;
        $cookie_auth = $_COOKIE['auth'];
        $sql = "SELECT pseudo,avatars,id_user,droits,email FROM users WHERE activation=1 AND droits!=0";
        $query=$connect->prepare($sql);
        $query->execute();
        while($data=$query->fetch(PDO::FETCH_ASSOC))
        {
            $id_user[$i] = $data['id_user'];

            $crypt_auth[$i] = sha1($id_user[$i])."-".sha1($_SERVER['REMOTE_ADDR']);
            if($cookie_auth == $crypt_auth[$i])
            {
                $_SESSION['id_user'] = (int)$id_user[$i];
                $_SESSION['pseudo'] = $data['pseudo'];
                $_SESSION['avatars'] = $data['avatars'];

                //met à jour la date last connexion
                date_last_co();
                if(isset($page_redirection_ok))
                {
                    header('Location:'.$page_redirection_ok.'');
                }
            }
            $i++;
        }
    }
    else
    {
        if(isset($page_redirection_nok))
        {
            header('Location:'.$page_redirection_nok.'');
        }
    }
}

//fonction récupérant les informations de l'utilisateur (remplace connexion_user)
function recup_data_user($pram,$action)
{
    require("connect_bdd.php");

    if($action == 'connexion')
    {
        $sql = "SELECT pseudo,avatars,id_user,droits,activation FROM users WHERE email= :email AND password= :password";
        $query=$connect->prepare($sql);
        $query->bindParam(':email',$pram["email"],PDO::PARAM_STR,320);
        $query->bindParam(':password',$pram["password"],PDO::PARAM_STR,60);
    }
    if($action == 'profil')
    {
        $sql = "SELECT civility,lastname,firstname,email,date_register,date_lastco FROM users WHERE id_user= :id_user";
        $query=$connect->prepare($sql);
        $query->bindParam(':id_user',$pram["id_user"],PDO::PARAM_INT);
    }
    else if($action == 'newmdp')
    {
        $sql="SELECT id_user,key_user FROM users WHERE email= :email AND activation=1";
        $query=$connect->prepare($sql);
        $query->bindParam(':email',$pram["email"],PDO::PARAM_STR,320);
    }
    else if($action == 'newmdverif')
    {
        $sql="SELECT count(id_user) FROM users WHERE key_user= :key_user AND id_user= :id_user  AND activation=1";
        $query=$connect->prepare($sql);
        $query->bindParam(':key_user',$pram["key_user"],PDO::PARAM_STR);
        $query->bindParam(':id_user',$pram["id_user"],PDO::PARAM_INT);
    }
    $query->execute();
    $data=$query->fetch(PDO::FETCH_ASSOC);
    return $data;
}

//fonction sui va mettre a jour les normes européennes et CF
function update_data_user($pseudo_user,$lastname_user,$firstname_user,$civility_user,$email_user,$id_user)
{
    require "connect_bdd.php";
    $sql=" UPDATE users SET lastname= :lastname_user, firstname= :firstname_user, civility= :civility, email= :email_user, pseudo= :pseudo_user	WHERE id_user= :id_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':pseudo_user',$pseudo_user,PDO::PARAM_STR,35);
    $query->bindParam(':lastname_user',$lastname_user,PDO::PARAM_STR,35);
    $query->bindParam(':firstname_user',$firstname_user,PDO::PARAM_STR,35);
    $query->bindParam(':civility',$civility_user,PDO::PARAM_STR,4);
    $query->bindParam(':email_user',$email_user,PDO::PARAM_STR,320);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_STR,35);
    $query->execute();
    //redifinition de la session
    $_SESSION['pseudo'] = $pseudo_user;
}

//fonction qui met à jour l'image de profil
function update_avatar($name_avatar)
{
    require "connect_bdd.php";
    $sql = "UPDATE users SET avatars = :name_avatar WHERE id_user= :id";
    $query=$connect->prepare($sql);
    $query->bindParam(':name_avatar',$name_avatar,PDO::PARAM_STR,500);
    $query->bindParam(':id',$_SESSION['id_user'],PDO::PARAM_INT);
    $query->execute();
    $_SESSION['avatars'] = $name_avatar;
    return true;
}

//fonction update le password
function update_password($password,$id_user)
{
    require("connect_bdd.php");
    $new_key = md5(microtime(TRUE)*100000);
    $passwordhash = password_hash($password,PASSWORD_BCRYPT);
    $sql = "UPDATE users SET password = :password, key_user= :new_key WHERE id_user= :id";
    $query=$connect->prepare($sql);
    $query->bindParam(':password',$passwordhash,PDO::PARAM_STR,60);
    $query->bindParam(':id',$id_user,PDO::PARAM_INT);
    $query->bindParam(':new_key',$new_key,PDO::PARAM_STR,100);
    $query->execute();
    return true;
}

//fonction recup infos pour
/************************* ******************************/

//fonction qui vérifie si le mot de passe est valide
function verif_valide_mdp($pw_user)
{
    if(!preg_match('/[a-z]/',$pw_user) || !preg_match('/[A-Z]/',$pw_user) || !preg_match('/[0-9]/',$pw_user) || strlen($pw_user)<4) {
        $error = 1;
    }else{
        $error = 0;
    }
    return $error;
}

//fonction mettant à jour la date de dernière connection
function date_last_co()
{
    require('connect_bdd.php');
    $id_user = $_SESSION['id_user'];
    //on actualise la date de derniere connection dans la bdd
    $sql="UPDATE users SET date_lastco = NOW() WHERE id_user= :id_user";
    $query=$connect->prepare($sql);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->execute();
}

/*fonction verif droits utilisateur
function verif_droit()
{
	$droits=0;
	if(isset($_SESSION['id_user'])){
		$id=$_SESSION['id_user'];
		require('connect_bdd.php');
		$sql="SELECT droits FROM users WHERE id_user=:id_user";
		$query=$connect->prepare($sql);
		$query->bindParam(':id_user',$id,PDO::PARAM_INT);
		$query->execute();
		$droits=$query->fetchColumn();
	}    
    return $droits;
}*/

//fonction essai
function redim_image($image)
{
    // On defini le header
    header('Content-type: ' .image_type_to_mime_type(IMAGETYPE_JPEG));

    $source = imagecreatefromjpeg($image); // La photo est la source
    $destination = imagecreatetruecolor(200, 150); // On crée la miniature vide

    // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);

    // On crée la miniature
    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

    // Le chemin vers le fichier de sauvegarde n'est pas défini, le flux brut de l'image sera affiché directement.
    imagejpeg($destination);
}
