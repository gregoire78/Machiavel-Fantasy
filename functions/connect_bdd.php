<?php
/***************************************************************
page connection à la base de donnée de machiavel_fanatsy en PDO
 ***************************************************************/

$pdo_conn 	= array();
$pdo_conn['hostname'] = 'localhost';
$pdo_conn['database'] = 'machiavel_fantasy';
$pdo_conn['username'] = 'root';
$pdo_conn['password'] = '';
// --------------------------------------------------------------
try {
    // chaine de connexion (DSN)
    $pdo_conn['strConn'] = 'mysql:host='.$pdo_conn['hostname'].';dbname='.$pdo_conn['database'];
    // persistant + encodage UTF-8
    $pdo_conn['extraParam'] = array(
        PDO::ATTR_PERSISTENT => true, 						// Connexions persistantes
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"	// encodage UTF-8
    );
    // Instancie la connexion
    $connect = new PDO($pdo_conn['strConn'], $pdo_conn['username'], $pdo_conn['password'], $pdo_conn['extraParam']);
    // rapport d'erreurs sous forme d'exceptions
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    $pdo_msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($pdo_msg);
}
$pdo_conn 	= array(); // on vide le tableau
// --------------------------------------------------------------
?>
