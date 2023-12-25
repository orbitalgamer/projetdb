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

        $a = $course ->  Verification_disponibilite($loadedcourse, $_SESSION['Id']);

        if($a){
            $result = $course->UpdateChauffeur($courseId);
            // Retournez une réponse si nécessaire
            //var_dump($result);
            if (isset($result['succes']) && $result['succes'] == '1'){
                echo '<div class="container"><a class="display 4">Course acceptée avec succès! </a></div>';
                $linkCourseEtat = new course(); 
                $linkCourseEtat->Date = date("Y-m-d H:i:s"); // Date d'aujourd'hui
                $linkCourseEtat->IdCourse = $courseId;
                $linkCourseEtat->IdEtat = 2;
    
                $linkCourseEtat->creationlien(); // Appel de la fonction pour insérer dans la table liencourseetat
                $linkCourseEtat->NotifyCourseAccepte($courseId); //envoie mail que se fait
                
                header("location:dashboard.php");
                //echo $_POST['Id'];
                //echo $_SESSION['Id'];
            } else {
                echo '<div class="container"><a class="display 4 alert alert-danger">Erreur lors de la mise à jour de la course.</a></div>';
            }
            return array();
            
        }
        else{
            header("location:dashboard.php?Error=1");
            echo '<div class="container"><a class="display-4 alert alert-danger"> Vous avez déjà une course pour cette periode la. </a></div>';
        }

        

    } else {
        echo 'ID de la course non spécifié.';
    }
} else {
    // Redirection ou gestion d'erreur si la requête n'est pas une requête POST
    echo 'Méthode de requête non autorisée.';
}
?>
