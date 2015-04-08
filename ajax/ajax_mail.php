<?php
//inclure le fichier des fonctions
include_once('../accessoires/functions_connect.php');
$email_user=trim($_POST['email_user']);
$ver = verif_existe('email',$email_user);
if(isset($_POST['email_user_data']))
{
	$email_user_data=trim($_POST['email_user_data']);
	//execute la fonction

	if($email_user!=$email_user_data && $ver!=0)
	{
		echo $ver;
	}
}
else
{
	echo $ver;
}

?>