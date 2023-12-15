<?php
include_once 'navbar.php';

include_once '../classes/avis.php';
include_once '../classes/course.php';

$avisObjet = new avis();
$course = new course();

if(!empty($_GET['Id'])) {
    $Id=$_GET['Id'];
    $avis = $avisObjet->Get($Id);
    $resultat = $course->Get($avis['IdCourse']);
}
else{
    header('location: avis.php');
}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Voir un avis</p>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <a class="h5">course commandé par </a> <a class="h4"> <?php echo $resultat['NomClient'].' '.$resultat['PrenomClient'];  ?></a>
        </div>

    </div>
    <div class="form-group">
        <a class="h5">Le client vous a laisser une note de </a> <a class="h4"> <?php echo $avis['Note'];?></a <a class="h5">/5</a>
    </div>
    <div class="form-group">
        <a class="h4">Il a l'aissé comme description : </a> <br> <a class="h5 p-4"> <?php echo $avis['Description'];?></a>
    </div>


</div>
</html>
