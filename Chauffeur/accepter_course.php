<?php

include_once 'navbar.php';

include_once '../classes/chauffeur.php';
include_once '../classes/course.php';

$course = new course();
//$linkCourseEtat = 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Id'])) {
        $courseId = $_POST['Id'];
        $chauffeurId = $_SESSION['Id'];
        
       
        $course->IdChauffeur = $chauffeurId;
        $loadedcourse = new Course();
        $loadedcourse->loadcourse($courseId); 
        
        if($course ->  Verification_disponibilite($loadedcourse)){
            $result = $course->UpdateChauffeur($courseId);
            // Retournez une réponse si nécessaire
            //var_dump($result);
            if (isset($result['succes']) && $result['succes'] == '1'){
                echo 'Course acceptée avec succès!';
                $linkCourseEtat = new course(); 
                $linkCourseEtat->Date = date("Y-m-d H:i:s"); // Date d'aujourd'hui
                $linkCourseEtat->IdCourse = $courseId;
                $linkCourseEtat->IdEtat = 2;
    
                $linkCourseEtat->creationlien(); // Appel de la fonction pour insérer dans la table liencourseetat
                
                header("location:dashboard.php");
                //echo $_POST['Id'];
                //echo $_SESSION['Id'];
            } else {
                echo 'Erreur lors de la mise à jour de la course.';
            }
            return array();
            
        }
        else{
            echo 'Vous avez déjà une course pour cette periode la.';
        }

        

    } else {
        echo 'ID de la course non spécifié.';
    }
} else {
    // Redirection ou gestion d'erreur si la requête n'est pas une requête POST
    echo 'Méthode de requête non autorisée.';
}
?>
