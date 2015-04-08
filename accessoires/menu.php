<?php
include_once('functions_connect.php');
include_once("functions_jeu.php");
include_once("functions_tools.php");
if(!isset ($_SESSION['id_user']))
{
    $droits = $avatar = $id_user = $pseudo =  NULL;
}
$query = recup_type_jeu();
$i=0;
while ($data=$query->fetch(PDO::FETCH_ASSOC)){
	$id_jeu_menu[$i]= $data['id_type_jeu'];
	$libelle_jeu_menu[$i]= $data['libelle_type_jeu'];
	$i++;
}
?>