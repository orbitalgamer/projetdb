<?php
include 'navbar.php';

include '../classes/mail.php';

$mail = new mail();

$Destinateur = "cyril.taquet@hotmail.be";
$sujet ="test mail";
$message = "ça fonctionne ?";

$mail->SendMail($Destinateur, $sujet, $message);
