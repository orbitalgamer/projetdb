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
    $image = $course->GetPhoto($Id);
}
else{
    header('location: avis.php');
}



?>

<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Voir un avis</p>
    </div>

    <div class="form-group">
        <a class="h5">Course commandée par </a> <a class="h4"> <?php echo $resultat['NomClient'].' '.$resultat['PrenomClient'];  ?></a>
        <a class="h5">et effectuée par </a> <a class="h4"> <?php echo $resultat['NomChauffeur'].' '.$resultat['PrenomChauffeur'];  ?></a>
    </div>
    <div class="form-group">
        <a class="h5">Le client a noté le service à </a> <a class="h4"> <?php echo $avis['Note'];?>/5</a <a class="h5"></a>
    </div>
    <div class="form-group">
        <a class="h4">Il a laissé comme description : </a> <br> <a class="h5 p-4"> <?php echo $avis['Description'];?></a>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='voircourse.php?Id=<?php echo $Id; ?>'">voir la course au complet</button>
    </div>

    <?php

    if(!empty($image)) {
        $string = '<div class="form-group">
        <a class="h4 pb-2">Le chauffeur à laissé les images suivante</a> <br>
        <div class="row justify-content-center">
  <span class="col-lg-8 col-sm-12 py-3">
    <div class="d-flex flex-column px-3">



      <div class="container-fluid  border bg-light mb-3 rounded">
        <div class="row ">';
        foreach ($image as $img) {
            $url = '../image/' . $img['CheminDAcces'];
            $string .= '       
                <div class="item col-sm-6 col-md-6 align-items-center">
                  <a href="' . $url . '" class="fancybox" data-fancybox="gallery1">
                    <img class="img img-fluid pt-3 pb-3" src="' . $url . '">
                  </a>
                </div>';

        }
        $string .= '</div>
      </div>
  </span>
        </div>

    </div>';
        echo $string;
    }

    ?>



    </div>


</div>
</html>
