<?php

include_once 'navbar.php';

include_once '../classes/chauffeur.php';
include_once '../classes/course.php';

$course = new course();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Id'])) {
        $courseId = $_POST['Id'];
        $chauffeurId = $_SESSION['Id'];
        // Effectuez votre requête SQL ici avec $courseId
       
            //$course->IdChauffeur = $chauffeurId;
        
        // Retournez une réponse si nécessaire
        //var_dump($result);
       
            echo 'Course acceptée avec succès!';
            
            $linkCourseEtat = new course(); // Assurez-vous que vous avez une classe pour liencourseetat
            $linkCourseEtat->Date = date("Y-m-d H:i:s");// Date d'aujourd'hui
            $linkCourseEtat->IdCourse = $courseId;
            $linkCourseEtat->IdEtat = 7; 

            $linkCourseEtat->creationlien();
            header("location:dashboard.php");
            //echo $_POST['Id'];
            //echo $_SESSION['Id'];
        
            echo 'Erreur lors de la mise à jour de la course.';
        
        return array();
        

    } else {
        echo 'ID de la course non spécifié.';
    }
} else {
    // Redirection ou gestion d'erreur si la requête n'est pas une requête POST
    echo 'Méthode de requête non autorisée.';
}
?>
