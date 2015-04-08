<?php
//création code alpha numérique
session_start();
$rand = md5(rand());
$rand = substr($rand,0,6);
$_SESSION['rand'] = $rand;
//création de l'image
$random = rand ( 1 , 17 );
$image = imagecreatefrompng('cap'.$random.'.png');
if( 1==$random)
{
	$text_color = imagecolorallocate($image,204, 122, 122);
}
if( 1<$random && 6>$random )
{
	$text_color = imagecolorallocate($image,255, 109, 0);
}
if( 5<$random && 10>$random )
{
	$text_color = imagecolorallocate($image,0, 51, 102);
}
if( 9<$random && 14>$random )
{
	$text_color = imagecolorallocate($image,20, 148, 20);
}
if( 13<$random)
{
	$text_color = imagecolorallocate($image,103, 139, 175);
}
imagestring($image,5,5,5,$rand,$text_color);
//afficher l'image
header('Content-type:image/png');
imagepng($image);
?>