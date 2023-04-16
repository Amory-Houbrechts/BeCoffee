<?php

require 'PHPmailer/src/PHPMailer.php';
require 'PHPmailer/src/SMTP.php';
require 'PHPmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Secure {
    public static function hash($password){
        return hash("sha256", PRE . $password . POST);
    }
}

function str_random($length){
	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function SendMail($Email, $Subject, $Body){
    $mail = new PHPmailer();

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = "true";

    $mail->IsHTML(true);

    $mail->SMTPSecure = 'ssl';

    $mail->Port = "465";

    $mail->Username = 'info.linkintown@gmail.com';

    $mail->Password = 'zmralswxiklhajrd';

    $mail->Subject = $Subject;

    $mail->setFrom('no-reply@linkintown.com');

    $mail->Body = $Body;

    $mail->addAddress($Email);

    if(!$mail->send()) {
        echo 'Erreur, message non envoyé.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Le message a bien été envoyé !';
    }

    $mail->smtpClose();

    $message = 'Un Email de confirmation vous a été envoyé';
}

function validateBelgianCardNumber($number) {
    $number = substr($number, 0, -2); // Supprime les deux derniers chiffres
    $number = strrev($number); // Inverse l'ordre des chiffres

    $sum = 0;
    for ($i = 0; $i < strlen($number); $i++) {
        $digit = (int) $number[$i];
        if ($i % 2 == 0) {
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        $sum += $digit;
    }

    return $sum % 10 == 0; // Vérifie que le dernier chiffre de la somme est zéro
}

?>