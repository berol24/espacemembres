<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP() ;             //Specifier que mailer pour utiliser SMTP
$mail->Host = 'smtp.gmail.com' ;  // Specifier le serveur
$mail->SMTPAuth = true ;          // Pour activer l’authentication
$mail->Username = 'bertinkuicheu@gmail.com';   
$mail->Password = 'xhferunzcglllsuu';                    
$mail->SMTPSecure = 'tls' ;    
$mail->Port = 587 ;
$mail->CharSet = "utf-8" ;              // TCP port de connexion
$mail->setFrom('bertinkuicheu@gmail.com', 'TF1');
$mail->addAddress($_POST['email'],"TF1");
$mail->isHTML(true) ;    // Pour activer l’envoi du mail sous forme HTML

$mail->Subject = 'Réinitialisation du mot de passe' ;
$mail->Body = 'Afin de réinitialiser votre mot de passe, merci de cliquer sur le lien suivant: <a href="localhost/espacemembres/new_password.php?email='.$_POST['email'].'&token='.$token.'">Réinitialisation du mot de passe</a>';

$mail->SMTPDebug = 0 ; //On desactive les logs de debug

if ( !$mail->send()) {
    $message = "Mail non envoyé ";
    echo 'Erreurs :' .$mail->ErrorInfo ;
} else {
    $message =  "Nous vous avons envoyé par mail des instructions pour réinitialiser votre mot de passe!"  ;
}

