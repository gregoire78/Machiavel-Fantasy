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

//Fonction pour trier les résultats d'une page
function tri_result($method_tri, $fichier)
{
    //Si il y a une méthode de tri de dans l'URL
    if(isset($_POST['tri']) || isset($_GET['tri']))
    {
        if(isset($_POST['tri']))
        {
            $switch_tri = $_POST['tri'];
        }
        else if(isset($_GET['tri']))
        {
            $switch_tri = $_GET['tri'];
        }

        $i=0;
        while (isset($method_tri[$i]))
        {
            if($switch_tri == $method_tri[$i]) $data['tri'] = $method_tri[$i];
            $i++;
        }
        if(!isset($data['tri'])) $data['tri'] = $method_tri[0];
    }
    //Sinon on tri selon la première méthode de tri
    else
    {
        $data['tri'] = $method_tri[0];
    }

    $data['fichier'] = $fichier."&tri=".$data['tri'];
    if(isset($_POST['ordre']) || isset($_GET['ordre']))
    {
        if(isset($_POST['ordre']))
        {
            $switch_ordre = $_POST['ordre'];
        }
        else if (isset($_GET['ordre']))
        {
            $switch_ordre = $_GET['ordre'];
        }
        switch($switch_ordre)
        {
            case "Croissant":
                $data['ordre'] = "ASC";
                break;
            case "Décroissant":
                $data['ordre'] = "DESC";
                break;
            default :
                $data['ordre'] ="ASC";
                break;
        }
    }
//Sinon on tri dans l'ordre décroissant
    else
    {
        //Si l'événement est passé on tri selon la première méthode par ordre décroissant sinon selon la première méthode par ordre croissant
        if(isset($_GET['passer']))
        {
            $data['ordre'] = "DESC";
        }
        else
        {
            $data['ordre'] ="ASC";
        }
    }
    $data['fichier'] = $data['fichier']."&ordre=".$data['ordre'];
    return $data;
}

//Fonction pour afficher le nombre de résultat par page
function view($view, $fichier)
{
    //Si on a déjà un nombre de d'événement par page sinon par défaut on affichera 5 actu par page
    if(isset($_GET['view']))
    {
        $i=0;
        while (isset($view[$i]))
        {
            if($_GET['view'] == $view[$i]) $data['view'] = $view[$i];
            $i++;
        }
        if(!isset($data['view'])) $data['view'] = $view[0];
    }
    else
    {
        $data['view'] = $view[0];
    }
    $data['fichier'] = $fichier."&view=".$data['view'];
    return  $data;
}

//Fonction pour vérifier si une page existe
function page($nb_page, $referer)
{
    //Si on est déjà sur une page
    if (isset ($_GET['page']))
    {
        if ($_GET['page']>$nb_page || $_GET['page']< 1)
        {
            header('Location: ' . $referer);
        }
        else
        {
            $page = (int)$_GET['page'];
        }
    }
    else
    {
        $page = 1;
    }
    return $page;
}
?>