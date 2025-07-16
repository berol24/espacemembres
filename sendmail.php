<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

$mail->isSMTP() ;             //Specifier que mailer pour utiliser SMTP
$mail->Host = 'smtp.gmail.com' ;  // Specifier le serveur gmail
$mail->SMTPAuth = true ;          // Pour activer l’authentication
$mail->Username = 'bertinkuicheu@gmail.com';   // adresse mail de l'emmeteur ou expediteur
$mail->Password = 'udrfldrlokpzhvyc  ';       // mot de passe de l'emmeteur (dans mot de passe de l'application sur gmail)            
$mail->SMTPSecure = 'tls' ;    
$mail->Port = 587 ;
$mail->CharSet = "utf-8" ;              // TCP port de connexion
$mail->setFrom('bertinkuicheu@gmail.com', 'NielsenIQ'); // adresse mail de l'emmeteur ou expediteur , le nom est optionnel
$mail->addAddress($_POST['email'],'NielsenIQ'); // adresse mail du destinataire 
$mail->isHTML(true) ;    // Pour activer l’envoi du mail sous forme HTML

$mail->Subject = 'Confirmation d\'email' ;
$mail->Body = 'Afin de valider votre adresse email, merci de cliquer sur le lien suivant: <a href="localhost/Fruistore/verification.php?email='.$_POST['email'].'&token='.$token.'">Confirmation</a>';

$mail->SMTPDebug = 0 ; //On desactive les logs de debug

if ( !$mail->send()) {
    $message = "Email non envoyé ";
    echo 'Erreurs :' .$mail->ErrorInfo ;
} else {
    $message =  "Un email vous a été envoyé, merci de consulter votre boite email!"  ;
}



