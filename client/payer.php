<?php
session_start();

include_once '../classes/course.php';

if(!empty($_GET['Id'])){
    $course = new Course();
    $course->Payer($_GET['Id']);
    header('location: paiement.php');

}
else{
    header('location: paiement.php');
}

?>
