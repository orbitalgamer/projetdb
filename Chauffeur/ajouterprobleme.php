
<?php
include_once 'navbar.php';
include_once '../classes/probleme.php';
include_once '../classes/adresse.php';
include_once '../client/info_adresse.php';

//pour faire fonctionner sélection adresse
$Bdd = new Bdd();
$base = $Bdd->getBdd();

$probleme = new probleme();
$adresse = new adresse();

if(!empty($_GET)){
    if(!empty($_GET['Id'])){
        $IdCourse = $_GET['Id'];
    }
    else{
        header('location: affichetout.php'); //si pas définit
    }
    if(!empty($_POST)){
        $adresse->Rue =strtolower( $_POST['Rue']);
        $adresse->Ville = strtolower($_POST['Ville']);
        $adresse->Numero = $_POST['Numero'];
        $adresse->CP = $_POST['CP'];

        $IdAdresse = $adresse->GetAdresse(); //cherche adresse

        if(empty($IdAdresse)){
            $adresse->latitude =1; //osef latidue pour adresse
            $adresse->longitude =1;

            $adresse->creation();//crée adresse si existe pas
        }
        $IdAdresse = $adresse->GetAdresse()[0]; //recherche l'Id de la nouvelle adresse créer

        $probleme->Description = $_POST['Description'];
        $probleme->Rouler = $_POST['Rouler'];
        $probleme->IdTypeProbleme = $_POST['TypeProbleme'];
        $probleme->IdAdresse = $IdAdresse;
        $probleme->IdCourse = $IdCourse;

        if($probleme->Insert() == array("succes"=>1)){
            header('location: affichetout.php');
        }
        else{
            echo 'erreur ajout';
        }
    }
}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Ajouter d'un problème</p>
    </div>

    <form class="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="probleme" class="h5">Type accident</label>
            <select class="form-control h5" id="probleme" name="TypeProbleme">
                <?php

                $typeprobleme = $probleme->GetAllType();

                foreach ($typeprobleme as $elem) {
                echo ' <option value="' . $elem["Id"] . '">' . $elem["Nom"] . '</option>';
                }

                ?>

            </select>
        </div>
        <div class="form-group">
            <a class="h5">Description</a>
            <textarea class="form-control" name="Description" placeholder="description" rows="6" required> </textarea>
        </div>

        <div class="form-group">
            <label for="rouler" class="h5" name="Rouler"/>Peut rouler</label>
            <select class="form-control" id="rouler" name="Rouler">
                <option selected="selected" value="0"> Non</option>
                <option value="1">Oui</option>
            </select>
        </div>

        <div class="form-group h5">
            <a class="">Adresse de l'accident</a>
            <input type="number" class="form-control m-1" name="Numero" placeholder="Numero" required/>
            <input type="text" class="form-control m-1" name="Rue" placeholder="Rue" required/>
            <input type="number" class="form-control m-1" name="CP" placeholder="CP" required/>
            <input type="text" class="form-control m-1" name="Ville" placeholder="Ville" required/>
        </div>

        <div class="form-group h5">
            <a class="">Ajouter des photos</a>
            <input type="file" class="form-control" name="images[]" multiple="">
        </div>




        <div class="d-flex row">
            <div class="col-sm-4 justify-content-center">
                <input type="submit" value="ajouter un problème" class="form-control bg-dark text-light" name="ajout"/>
            </div>
        </div>

</div>
</html>
