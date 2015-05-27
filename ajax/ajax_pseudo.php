<?php
//inclure le fichier des fonctions
include_once('../functions/functions_connect.php');

if(isset($_POST['pseudo_user']))
{
    $pseudo_user = trim($_POST['pseudo_user']);
    $ver = verif_existe('id_user', 'users', 'pseudo', $pseudo_user);
    if (isset($_POST['pseudo_user_data']))
    {
        $pseudo_user_data = trim($_POST['pseudo_user_data']);

        //execute la fonction
        if ($pseudo_user != $pseudo_user_data && $ver != 0)
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