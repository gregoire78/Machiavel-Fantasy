<?php
include_once('../functions/functions_connect.php');

if(isset($_POST['title_jeu']))
{
    $title_jeu = trim($_POST['title_jeu']);
    $ver = verif_existe('id_jeu', 'jeu', 'title_jeu', $title_jeu);

    if (isset($_POST['title_jeu_data']))
    {
        $title_jeu_data = trim($_POST['title_jeu_data']);

        //execute la fonction
        if ($title_jeu != $title_jeu_data && $ver != 0)
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