<?php
/**********************
script déconnexion
 *********************/
session_start();
session_unset();//on efface toutes les variables de la session
session_destroy(); // Puis on détruit la session
if(isset($_COOKIE['auth']))
{
    setcookie('auth', NULL, -1); //efface cookie
}
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
header('Location: ' . $referer);
?>