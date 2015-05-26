<?php
/**
 * Created by PhpStorm.
 * User: Maillard
 * Date: 06/05/2015
 * Time: 14:29
 */

//Fonction pour notifier d'une modification (table historique)
function create_historique($table_historique, $text_historique, $id_user)
{
    require("connect_bdd.php");
    $sql="INSERT INTO historique	  ( id_user,  table_historique,  text_historique, date_historique )
		  VALUES 				      (:id_user, :table_historique, :text_historique, NOW() );";
    $query=$connect->prepare($sql);
    $query->bindParam(':table_historique',$table_historique,PDO::PARAM_INT);
    $query->bindParam(':id_user',$id_user,PDO::PARAM_INT);
    $query->bindParam(':text_historique',$text_historique,PDO::PARAM_STR,100);
    $query->execute();
}

//Fonction pour recupérer l'historique
function recup_historique($restrict,$tri, $ordre, $page, $historique_page)
{
    $nb_historique = ($page-1)*$historique_page;
    require("connect_bdd.php");
    if(isset($restrict))
    {
        $sql="	SELECT id_historique, pseudo, avatars, h.id_user, droits, text_historique, date_historique
			    FROM historique h

                JOIN users u
                ON u.id_user = h.id_user

			    WHERE table_historique = :table_historique

			    ORDER BY ".$tri." ".$ordre."

			    LIMIT   :nb_historique, :historique_page" ;
    }
    else
    {
        $sql="	SELECT id_historique, pseudo, avatars, h.id_user, droits, text_historique, date_historique
			    FROM historique h

                JOIN users u
                ON u.id_user = h.id_user

			    ORDER BY ".$tri." ".$ordre."

			    LIMIT   :nb_historique, :historique_page" ;
    }

    $query=$connect->prepare($sql);
    $query->bindParam(':nb_historique',$nb_historique,PDO::PARAM_INT);
    $query->bindParam(':historique_page',$historique_page,PDO::PARAM_INT);
    if(isset($restrict))$query->bindParam(':table_historique',$restrict,PDO::PARAM_INT);
    $query->execute();
    return $query;
}

//Fonction pour supprimer l'historique
function delete_historique($cocher ,$restrict)
{
    require("connect_bdd.php");
    if(isset($cocher))
    {
        $i=0;
        $restrict = "WHERE id_historique IN (0" ;
        while(isset($cocher[$i]))
        {
            $restrict = $restrict.", ".$cocher[$i];
            $i++;
        }
        $restrict = $restrict.")";
        $sql="  DELETE FROM historique
            ".$restrict ;
    }
    else if (isset($restrict))
    {
        $sql="  DELETE FROM historique
                WHERE table_historique=:table_historique" ;
    }
    else
    {
        $sql="  DELETE FROM historique";
    }

    $query=$connect->prepare($sql);
    if(isset($restrict))$query->bindParam(':table_historique',$restrict,PDO::PARAM_INT);
    $query->execute();
}

function recup_lign_historique($restrict)
{
    require("connect_bdd.php");
    if(isset($restrict))
    {
        $sql = "SELECT COUNT(*)
			    FROM  historique
			    WHERE table_historique =:table_historique";
    }
    else
    {
        $sql = "SELECT COUNT(*)
			    FROM  historique";

    }

    $query=$connect->prepare($sql);
    if(isset($restrict))$query->bindParam(':table_historique',$restrict,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetchColumn();
    return $data;
}

?>