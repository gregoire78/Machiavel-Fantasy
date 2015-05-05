<?php
//inclure le fichier des fonctions
include_once('../accessoires/functions_connect.php');
$pseudo_user=trim($_POST['pseudo_user']);

if(isset($_POST['pseudo_user_data']))
{
	$pseudo_user_data=trim($_POST['pseudo_user_data']);
	//execute la fonction
	if($pseudo_user!=$pseudo_user_data)
	{
		echo verif_existe('id_user','users','pseudo',$pseudo_user);
	}
}
else
{
	echo verif_existe('id_user','users','pseudo',$pseudo_user);
}

?>