<?php
$hostname = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'] ;
date_default_timezone_set('Europe/Paris');

include_once("mail_config.php");

$message = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Message de confirmation du compte</title>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td align="center" bgcolor="#7F838A" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                        <img src="http://'.$hostname.'/images/mail/h1Email.png" alt="Machiavel Fantasy" width="350" height="128" style="display: block;" />
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>'.$civility_user.' '.$lastname_user.' ,</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Vous avez demandé a changer votre mot de passe sur <a href="http://'.$hostname.'" style="color: #153643;text-decoration: none;font-weight: bold">Machiavel Fantasy</a>. Il vous suffit de cliquer sur ce lien :
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 20px 0;" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" style="background-color:#505050; border:1px solid #353535; border-radius:5px;">
                                        <tr>
                                            <td align="center" valign="middle" style="font-family: Arial, sans-serif;color:#FFFFFF;font-size:16px; font-weight:bold; letter-spacing:-.5px; padding:15px 30px 15px 30px;">
                                                <img src="http://'.$hostname.'/images/mail/Lock.png" width="15" alt="lock" />&nbsp;&nbsp;&nbsp;<a href="http://'.$hostname.'/oublie_mdp.php?pseudo='.urlencode($id_user).'&key='.urlencode($key).'" target="_blank" style="color:#FFFFFF; text-decoration:none;">Modifier mon MDP</a>&nbsp;&nbsp;&nbsp;<img src="http://'.$hostname.'/images/mail/Lock.png" width="15" alt="lock" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0; color: #153643; font-family: Arial, sans-serif; font-size: 12px; line-height: 20px;">
                                    Votre nom d\'ultilisateur : '.$pseudo_user.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 20px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="left" width="50%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                    &copy; <a href="http://'.$hostname.'" target="_blank" style="color: #ffffff;"><font color="#ffffff">Machiavel Fantasy</font></a>, '.date("Y").'
                                </td>
                                <td align="left" width="50%" style="color:#FF8181; font-family: Arial, sans-serif; font-size: 12px;">
                                    Si vous n\'êtes pas à l\'origine de la création de ce compte ne tenez pas compte de cet email.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
';

$succesSendMail=config_envoie_mail('gmail','newmdp@machiavel.fr',$email_user,'Vous avez demandé un nouveau mot de passe',$message);

?>