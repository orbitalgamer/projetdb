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
       
        $course->IdChauffeur = $chauffeurId;
        $result = $course->UpdateChauffeur($courseId);
        // Retournez une réponse si nécessaire
        //var_dump($result);
        if (isset($result['succes']) && $result['succes'] == '1'){
            echo 'Course acceptée avec succès!';
            header("dashboard.php");
            //echo $_POST['Id'];
            //echo $_SESSION['Id'];
        } else {
            echo 'Erreur lors de la mise à jour de la course.';
        }
        return array();
        

    } else {
        echo 'ID de la course non spécifié.';
    }
} else {
    // Redirection ou gestion d'erreur si la requête n'est pas une requête POST
    echo 'Méthode de requête non autorisée.';
}
?>
