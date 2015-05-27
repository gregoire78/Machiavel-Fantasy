<?php
//inclure le fichier des fonctions
include_once('../functions/functions_connect.php');

if(isset($_POST['email_user']))
{
    $email_user = trim($_POST['email_user']);
    $ver = verif_existe('id_user', 'users', 'email', $email_user);
    if (isset($_POST['email_user_data']))
    {
        $email_user_data = trim($_POST['email_user_data']);
        //execute la fonction

        if ($email_user != $email_user_data && $ver != 0)
        {
            echo $ver;
        }
    }
    else
    {
        echo $ver;
    }
}
else
{
    header('Location:/index.php');
}

?>