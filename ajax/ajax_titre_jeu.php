<?php
include_once('../accessoires/functions_connect.php');
$title_jeu=trim($_POST['title_jeu']);

if(isset($_POST['title_jeu_data']))
{
    $title_jeu_data=trim($_POST['title_jeu_data']);
    //execute la fonction
    if($title_jeu!=$title_jeu_data)
    {
        echo verif_existe('id_jeu','jeu','title_jeu',$title_jeu);
    }
}
else
{
    echo verif_existe('id_jeu','jeu','title_jeu',$title_jeu);
}

?>