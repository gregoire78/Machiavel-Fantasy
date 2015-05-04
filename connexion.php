<?php
session_start();
session_regenerate_id();

include_once('accessoires/menu.php');
//l'auto connexion
auto_connexion('profil.php',NULL,NULL);

if(isset($_POST['valider']))
{
    $email_user=htmlentities(trim($_POST['email_user']));/*on prepare la chaine de caractere entrée par l'utilisateur*/
	$pw_user=htmlentities($_POST['password_user']);

    //on réupere le hash à partir de l'email
    $hash = recup_hash('email',$email_user);

    //on vérifie le hash avec le mot de passe entrez par l'utilisateur
    if (password_verify($pw_user,$hash))
    {

        $data = connexion_user($email_user,$hash);
        if($data['droits'] == 0)
        {
            $error_connexion = "Vous êtes Banni !!!";
        }
        else
        {
            $_SESSION['id_user'] = (int)$data['id_user'];
            $_SESSION['pseudo'] = $data['pseudo'];
            $_SESSION['avatars'] = $data['avatars'];

            //defini la date de dernière connection
            date_last_co();

            //si il a cliqué sur rester connecter
            if (isset($_POST['stayco'])) {
                $crypt_auth = sha1($data['id_user']) . "-" . sha1($_SERVER['REMOTE_ADDR']);
                $expire = time() + 3600 * 24 * 3; //dans 3 jours
                setcookie('auth', $crypt_auth, $expire, '/', null, false, true);
            } else {
                //on défini une session du temps
                $_SESSION['timestamp'] = time();
            }
            header('Location:profil.php');
        }
    }
    else if(!empty($email_user) || !empty($pw_user))
    {
        $error_connexion = "Email ou mot de passe Incorrecte";
    }
}

include_once("connexion.html");