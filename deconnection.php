<?php
session_start();
session_unset(); //déconencte sessions
session_destroy(); //supprime session

header("location: index.php"); //renvoie vers la page de base
?>