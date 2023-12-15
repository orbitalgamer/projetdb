<?php

include_once 'navbar.php';

include_once '../classes/chauffeur.php';
include_once '../classes/course.php';

$course = new course();


    if (!empty($_GET['IdClient'])) {
        $courseId = $_GET['IdClient'];
        $chauffeurId = $_SESSION['Id'];
        // Effectuez votre requête SQL ici avec $courseId

        $linkCourseEtat = new course();

        $linkCourseEtat->IdCourse = $courseId;
        $linkCourseEtat->IdEtat = 6;

        $linkCourseEtat->creationlien();

        // Retournez une réponse si nécessaire
        //var_dump($result);

        header('location: dashboard.php');


    }
    else {
        header('location: dashboard.php');
    }

?>
