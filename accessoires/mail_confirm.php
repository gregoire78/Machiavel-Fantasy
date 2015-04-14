<?php
$ipserveur = $_SERVER['SERVER_ADDR'];
if($ipserveur != "127.0.0.1")
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
$subject = 'Bienvenue sur Machiavel Fantasy';

// message
$message = '<h2>Bienvenue '.$civility_user.' '.$lastname_user.' sur Machiavel Fantasy !</h2>
			<p>votre pseudo est : '.$pseudo_user.'</p>
			<p>Pour activer votre compte veuillez cliquer sur le lien suivant : <a href="http://machiavel.fr/activation.php?pseudo='.urlencode($pseudo_user).'&key='.urlencode($key).'">Activer mon compte</a></p>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .='Content-Transfer-Encoding: 8bit' . "\r\n";

// Additional headers
//$headers .= 'To: "'.$mail.'"' . "\r\n";
$headers .= 'From: Machiavel Fantasy <inscription@machiavel.fr>' . "\r\n";

// Mail it
$res = mail($to, $subject, $message, $headers);
if($res == false)
{
    die('Erreur lors de l\'envoi du mail');
}
?>