<?php
/*-----------------------Fonction pour formater la date-----------------------------*/
function format_date($date)
{
	setlocale (LC_TIME, 'fr_FR.utf8','fra');
	$date=utf8_encode(strftime("%A %d %B %Y &agrave; %Hh%M", strtotime($date)));
	return $date;
}

//Fonction pour vérifier les droits de l'utilisateur quand il veut modifier ce qu'il a posté
function verif_mod_supp($table, $id_table)//$id_table représente id par rapport à la table  et $table à la table sur laquelle on travail.
{
	require("connect_bdd.php");
	$sql="	SELECT id_user
			FROM ".$table."		
			WHERE id_".$table."=:id_table AND statut_".$table." = 1";
			
	$query=$connect->prepare($sql);
	$query->bindParam(':id_table',$id_table,PDO::PARAM_INT);
	$query->execute();	
	$data=$query->fetch(PDO::FETCH_ASSOC);
	
	if($id_user_table = $data['id_user'])
	{
		
		if($_SESSION['id_user'] != $id_user_table &&  $_SESSION['droits'] < 3)
		{
			header("location:index.php");
		}
	}
	else
	{
		header("location:index.php");
	}
}

//fonction qui recupere le rang a partir de l'id
function recup_rang($droits)
{
    switch($droits) {
        case 0 : $rang = 'banni';
            break;
        case 1 : $rang = 'utilisateur';
            break;
        case 2 : $rang = 'modérateur';
            break;
        case 3 : $rang = 'administrateur';
            break;
        default : $rang = 'N/A';
            break;
    }
    return $rang;
}
?>