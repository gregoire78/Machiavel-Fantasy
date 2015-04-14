<?php
$ipserveur = $_SERVER['SERVER_ADDR'];
if($ipserveur == "127.0.0.1")
{
	ini_set("SMTP", "smtp-auth.sfr.fr");
	ini_set('smtp_port',587);
}
else
{
	ini_set("SMTP", "smtp.completel.net");
}
ini_set('sendmail_from' , 'greg.autre@gmail.com');
// multiple recipients
$to  = $email_user;

// subject
$subject = 'Vous avez demandé un nouveau mot de passe';

// message
$message = '<h2>Service Mot de passe de Machiavel Fantasy !</h2>
			<p>Cher(e) ami(e),</p>
			<p>voici votre nouveau mot de passe : <b>'.$randmdp.'</b></p>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .='Content-Transfer-Encoding: 8bit' . "\r\n";

// Additional headers
//$headers .= 'To: "'.$mail.'"' . "\r\n";
$headers .= 'From: Machiavel Fantasy <mdpservice@machiavel.fr>' . "\r\n";

// Mail it
$res = mail($to, $subject, $message, $headers);
if($res == false)
{
    die('Erreur lors de l\'envoi du mail :(');
}
?>