<?php 
require_once "bdd.php";
include_once "personne.php";
include_once "course.php";  
include_once "commanderCourse.php";


$Personne1 = new Personne($base);
$Personne1->Id = 15 ;
$Personne1->selection();
commanderCourse($Personne1,$base);



//J'ai supprimer toutes les contraintes lié au clé dans phpMyAdmin pour faire ça

?>