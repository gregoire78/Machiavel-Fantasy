<?php
/*if($ipserveur == "127.0.0.1")
{
	ini_set("SMTP", "smtp-auth.sfr.fr");
	ini_set('smtp_port',587);
}
else
{
	ini_set("SMTP", "smtp.completel.net");
}*/
require 'PHPMailer/PHPMailerAutoload.php';



function config_envoie_mail($type_envoie,$from,$to,$sujet,$message){

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    if($type_envoie == "smtp")
    {
        /*------email smtp local----*/
        //Set the hostname of the mail server
        $mail->Host = "machiavel.fr";
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 25;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        /*---------------------------*/
    }
    else if($type_envoie == "gmail")
    {
        /*--------email par gmail---------*/
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "greg.autre@gmail.Com";
        //Password to use for SMTP authentication
        $mail->Password = "perle oute008";
        //cherser
        $mail->CharSet = 'UTF-8';
        /*-------------------------------*/
    }

    //Set who the message is to be sent from
    $mail->setFrom($from, 'Machiavel Fantasy');
    //Set who the message is to be sent to
    $mail->addAddress($to);
    //Set the subject line
    $mail->Subject = $sujet;
    //Read an HTML message body from an external file, convert referenced images to embedded,

    $mail->msgHTML($message);
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';

    //send the message, check for errors
    if (!$mail->send()) {
        $succesSendMail = false;
    } else {
        $succesSendMail = true;
    }
    return $succesSendMail;
}

?>