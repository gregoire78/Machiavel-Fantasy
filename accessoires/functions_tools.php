<?php
/*-----------------------Fonction pour formater la date-----------------------------*/
function format_date($date)
{
	setlocale (LC_TIME, 'fr_FR.utf8','fra');
	$date=ucfirst(utf8_encode(strftime("%A %d %B %Y &agrave; %Hh%M", strtotime($date))));
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
        case 0 : $rang = 'Banni';
            break;
        case 1 : $rang = 'Utilisateur';
            break;
        case 2 : $rang = 'Adhérent';
            break;
        case 3 : $rang = 'Administrateur';
            break;
        default : $rang = 'N/A';
            break;
    }
    return $rang;
}

//Fonction qui calcul le nombre page
function recup_nb_page($total_liste, $nombre_by_page)
{
    $nb_page = ceil($total_liste / $nombre_by_page);
    return $nb_page;
}
?>