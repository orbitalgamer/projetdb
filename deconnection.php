<?php
session_start();
session_unset(); //déconencte sessions
session_destroy(); //supprime session
echo 'deconnecte';
//header("location: index.php"); //renvoie vers la page de base
?>