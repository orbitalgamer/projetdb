<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/src/Exception.php';
require 'Phpmailer/src/PHPMailer.php';
require 'Phpmailer/src/SMTP.php';

include_once "bdd.php";
include_once "localite.php";






class mail{


    private $Bdd;




    public function __construct(){

        $db = new Bdd();
        $this->Bdd = $db->getBdd();

    }

    public function SendMail($Dest, $sujet, $message){


        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 3;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp-auth.mailprotect.be';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'info@themistest.be';                     //SMTP username
            $mail->Password   = 'd92d9tvE53Jf4H5s02jD';                               //SMTP password ossef que pas saché
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->setFrom('info@themistest.be', 'taxeasy-info');
            $mail->addAddress($Dest);     //Add a recipien
            $mail->addReplyTo('221055@umons.ac.be', 'reply-to');
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $sujet;
            $mail->Body    = $message;

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


}


?>