<?php
include_once 'navbar.php';

include_once '../classes/course.php';
include_once '../classes/avis.php';

$course = new course();
$avisObjet = new avis();

if(!empty($_GET['Id'])) {
    $Id=$_GET['Id'];
    $resultat = $course->Get($Id);
    $etats = $course->GetEtat($Id);
    $avis = $avisObjet->GetId($Id);
    $photo = $course->GetPhoto($Id);

}
else{
    header('location: course.php');
}

?>

<html>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Voir une Course</p>
    </div>
    <?php
    if(!$resultat['Inpaye']) {
        echo'
        <div class="form-group text-center" >
        <a class="h4 p-2 alert-danger">Cette course n est pas payée</a >
    </div >';
    }

    ?>

    <div class="form-group">
        <a class="h5">Commandé par </a> <a class="h4"> <?php echo $resultat['NomClient'].' '.$resultat['PrenomClient'];  ?></a>
        <a class="h5"> contactable par </a> <a class="h4"> <?php echo $resultat['TelClient']; ?></a> <a class="h5"> ou </a>
        <a class="h4"> <?php echo $resultat['EmailClient']; ?></a>
    </div>
    <div class="form-group">
        <a class="h5">Effectué par </a> <a class="h4"> <?php echo $resultat['NomChauffeur'].' '.$resultat['PrenomChauffeur'];  ?></a>
        <a class="h5"> contactable par </a> <a class="h4"> <?php echo $resultat['TelChauffeur']; ?></a> <a class="h5"> ou </a>
        <a class="h4"> <?php echo $resultat['EmailChauffeur']; ?></a>
    </div>
    <div class="form-group">
        <a class="h5">La course a été effectué le </a> <a class="h4"> <?php echo $resultat['DateDebut'];  ?></a>
        <a class="h5"> Partant de </a> <a class="h4"> <?php echo $resultat['NumeroDepart'].' '.$resultat['RueDepart'].' à '.$resultat['CPDepart'].' '.$resultat['VileDepart']; ?></a> <a class="h5"> jusque </a>
        <a class="h4"> <?php echo $resultat['NumeroFin'].' '.$resultat['RueFin'].' à '.$resultat['CPFin'].' '.$resultat['VileFin']; ?></a> <a class="h5"> par la voiture </a> <a class="h4"> <?php echo $resultat['Plaque'];?></a>
    </div>
    <div class="form-group">
        <a class="h5">Le chauffeur à roulé sur </a> <a class="h4"> <?php echo $resultat['DistanceParcourue'];?></a>
        <a class="h5">km à un tarif de </a> <a class="h4"> <?php echo $resultat['Tarif']; ?></a> <a class="h5">€/km pour un prix total de</a>
        <a class="h4"> <?php echo $resultat['Prix'];?>€</a>
    </div>
    <div class="form-group">
        <a class="h5">Historique des états </a>
        <table class="table table-striped table-responsive-md container-fluid">
            <thead class="table-light">
            <tr>
                <th scope="col h3">#</th>
                <th scope="col h3">Nom</th>
                <th scope="col h3">Date</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            $compteur=1;
            foreach ($etats as $elem){
                echo '<tr><th>'.$compteur.'</th>
                        <th>'.$elem['Nom'].'</th>
                        <th>'.$elem['Date'].'</th>
                        </tr>';
                $compteur += 1;
            }

            ?>
            </tbody>
        </table>
    </div>
    <?php
    if(!empty($avis)){
        echo '<div class="form-group">
        <a class="h4">Avis</a><br>
        <a class="h5"> Le client à noté la coure à </a> <a class="h4"> </a> <a class="h5"> '.$avis['Note'].'/5</a><br>
        <a class="h5"> Descripition : </a><br> <a class="h4 pl-4"> '.$avis['Description'].'</a>
    </div>';
    }

    if(!empty($photo)){ //afficahge photo
        echo '<div class="form-group">
                <a class="h4">Photo du chauffeur</a><br>

                <div class="row justify-content-center">
                                <span class="col-lg-8 col-sm-12 py-3">
                                    <div class="d-flex flex-column px-3">
                                        <div class="container-fluid  border bg-light mb-3 rounded">
                                            <div class="row ">';
                                                foreach($photo as $img) {
                                                    $url = '../image/' . $img['CheminDAcces'];
                                                    echo '       
                                                            <div class="item col-sm-6 col-md-6 align-items-center">
                                                              <a href="' . $url . '" class="fancybox" data-fancybox="gallery1">
                                                                <img class="img img-fluid pt-3 pb-3" src="' . $url . '">
                                                              </a>
                                                            </div>';
                                                }
                        echo '              </div>
                                        </div>
                                </span>
                            </div>
                        </div>
                    </div>';
    }
    ?>

</div>
</html>
