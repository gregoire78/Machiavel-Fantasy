<?php
session_start();
include_once("accessoires/functions_forum.php");
if(isset($_POST['create']))
{	
	$title_forum = $_POST['title_forum'];
	$id_parent = $_POST['id_parent'];
	$lien_forum = $_POST['lien_forum'];
	$type_forum = $_POST['type_forum'];
	$text_forum = $_POST['text_forum'];
	create_forum($title_forum, $text_forum, $id_parent, $lien_forum, $type_forum);
}
include_once("admin_forum.html");
?>