<?php
include_once 'navbar.php';
include_once '../classes/probleme.php';
include_once '../classes/maintenance.php';

$probObjet = new probleme();
$maintenanceObjet = new Maitenance();

if(!empty($_GET['Id'])){
    $Id=$_GET['Id']; // prend l'id du problème
    $prob = $probObjet->GetAccidentId($Id);
    $image = $probObjet->GetPhoto($Id);
    if(empty($prob)){
        header('location: probleme.php'); //si ce problème existe pas
    }
}
else{
    header('location: probleme.php'); //si pas d'Id définit
}

if(!empty($_POST)){
    if(!empty($_POST['AjoutMaintenance'])){ //regarde si bien demander ajoute d'une nouvelle maintenanc
        $maintenanceObjet->DateFin = $_POST['DateFin'];
        $maintenanceObjet->DateDebut = $_POST['DateDebut'];
        $maintenanceObjet->Description = $_POST['Description'];
        $maintenanceObjet->Insert($Id); //ajoute de la nouvelle maintenance
    }
    if(!empty($_POST['Regler'])){
        if($_POST['Supprimer'] == "regler") {
            $probObjet->Regler($Id);
        }
    }
}

?>

<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Consultation d'un problème</p>
    </div>

    <?php

    $prob = $probObjet->GetAccidentId($Id);


    if($prob['Regle']) {
        echo'
        <div class="form-group text-center" >
        <a class="h4 p-2">Ce probleme est réglé</a >
    </div >';
    }
    else{
        echo'
        <div class="form-group text-center">
        <a class="h3 p-2 alert-danger">Ce probleme n est pas réglé</a >
    </div >';
    }
    ?>

    <div class="form-group">
        <a class="h4 pb-2">Concerne le véhicule suivant </a>
        <div class="container pt-1">
            <div class="row">
                <div class="col-md-3">
                    <a class="h5">Plaque : <?php echo $prob['plaque']; ?></a>
                </div>
                <div class="col-md-3">
                    <a class="h5">Marque : <?php echo $prob['marque']; ?></a>
                </div>
                <div class="col-md-3">
                    <a class="h5">Modele : <?php echo $prob['model']; ?></a>
                </div>
                <div class="col-md-3">
                    <a class="h5">Kilométrage : <?php echo $prob['kilometrage']; ?> km</a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <a class="h4 pb-2">Remonter par <?php echo $prob['nomChauffeur'] . ' ' . $prob['prenomChauffeur']; ?> </a>
    </div>

    <div class="form-group">
        <a class="h4 pb-2">Description du chauffeur</a> <br>
        <a class="h5 container"> <?php echo $prob['Description']; ?></a>
    </div>
    <?php
    if(!empty($image)){
        $string = ' <div class="form-group">
        <a class="h4 pb-2">Photo du problème</a> <br>
        <div class="row justify-content-center">
  <span class="col-lg-8 col-sm-12 py-3">
    <div class="d-flex flex-column px-3">



      <div class="container-fluid  border bg-light mb-3 rounded">
        <div class="row ">';
        foreach($image as $img){
            $url = '../image/'.$img['CheminDAcces'];
            $string.= '       
                <div class="item col-sm-6 col-md-6 align-items-center">
                  <a href="'.$url.'" class="fancybox" data-fancybox="gallery1">
                    <img class="img img-fluid pt-3 pb-3" src="'.$url.'">
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




    <div class="form-group">
        <a class="h4 pb-2">Maintenance prévu</a>
        <?php
        $maintenance = $maintenanceObjet->GetId($Id);
        foreach ($maintenance as $elem){
            echo '<div class="container pt-2">
                <div class="row">
                    <div class="col-6">
                        <a class="h5"> Prévue de '.$elem['DateDebut'].' à '.$elem['DateFin'].'</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a class="h5">Description : '.$elem['Description'].'</a>
                    </div>
                </div>
                
                
            </div>';
        }

        ?>


        <div class="container pt-4">
            <a class="h4">Ajouter une maintenance ?</a>
            <form class="justify-content-center" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <a class="h5"> Prévue de <input class="form-control" type="date" min="<?php echo date('Y-m-d'); ?>" name="DateDebut" required> à <input type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" name="DateFin" required></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a class="h5">Description :</a><br>
                        <textarea class="form-control" name="Description" rows="5" cols="50" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md-12">
                        <input type="submit" class="form-control bg-dark text-light pt-2" name="AjoutMaintenance" value="Ajotuer une Maintenance">
                    </div>
                </div>
            </form>

        </div>

        <?php
        if(!$prob['Regle']){
            echo'<div class="container pt-4">
            <a class="h4">Regler le problème ?</a><br>
            <a class="h5">Erivez reglé pour reglé le problème</a>
            <form class="justify-content-center" method="POST">
                <div class="row justify-content-center">
                    <div class="col-md-6 d-flex">
                        <input type="text" class="form-control" placeholder="regler" name="Supprimer" required>
                        <input type="submit" class="form-control bg-dark text-light pt-2" name="Regler" value="Regler ce problème">
                    </div>
            </form>

        </div>';
        }

        ?>

    </div>
</div>
</html>
