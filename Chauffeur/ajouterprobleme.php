
<?php
include_once 'navbar.php';
include_once '../classes/probleme.php';
include_once '../classes/adresse.php';
include_once '../classes/course.php';


//pour faire fonctionner sélection adresse
$Bdd = new Bdd();
$base = $Bdd->getBdd();

$probleme = new probleme();
$adresse = new adresse();
$course = new course();

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

        $IdProbleme = $probleme->Insert();
        if($IdProbleme != array("error"=>1)){

            //va transferer les photo
            function reArrayFiles($file_post){
                $file_ary = array();
                $file_count = count($file_post['name']);
                $file_keys = array_keys($file_post);
                for ($i=0; $i<$file_count; $i++){
                    foreach($file_keys as $key){
                        $file_ary[$i][$key] = $file_post[$key][$i];
                    }
                }
                return $file_ary;
            }


            if(!empty($_FILES['images']['Name'])) {
                //mets photo dans ordre plus simple
                $img = reArrayFiles($_FILES['images']);
                $url = "../image/probleme/" . $IdProbleme;

                mkdir($url); //crée dossier pour tous les mettres
                //var_dump($img);
                $_SESSION['add'] = 5; // evite de repasser dans la boucle pour insert

                $a = 0;
                foreach ($img as $image) {
                    if ($image['error']) {
                        echo "<p class='alert alert-danger' role='alert'>" . $image['name'] . " - " . $erreur[$image['error']] . "<br>";
                    }
                    $b = explode('.', $image['name']);
                    $c = end($b);
                    $ext = strtolower($c);
                    $aut = array('bmp', 'tiff', 'jpeg', 'jpg', 'gif', 'png', 'svg', 'tif');
                    if (in_array($ext, $aut)) {

                        if (move_uploaded_file($image['tmp_name'], $url . "/" . $a . "." . $ext)) {
                            //echo "<p class='alert alert-success' role='alert'>".$image['name']." - fichier transferé<br>";
                            //echo $_SESSION['IdPa'] ." ".$ext." ".$a."<br>";
                            $probleme->InsertPhoto("probleme/" . $IdProbleme . "/" . $a . "." . $ext, $IdProbleme); //ajoute dans la dB

                        } else {
                            echo "<p class='alert alert-danger' role='alert'>" . $image['name'] . " - fichier non transféré<br>";
                        }
                    } else {
                        echo "<p class='alert alert-danger' role='alert'>" . $image['name'] . " - fichier invalide<br>";
                    }
                    $a++;
                }
            }
            var_dump($IdProbleme);
            $cour = $course->Get($IdCourse);
            $probleme->Notify($_SESSION['Id'], $cour['Plaque'],  $IdProbleme ); //notifier les personnes
            header('location: affichetout.php');
        }
        else{
            echo "<p class='alert alert-danger' role='alert'> Erreur d'ajout<br>";
        }
    }
}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Ajout d'un problème</p>
    </div>

    <form class="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="probleme" class="h5">Type de problème</label>
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
            <a class="">Adresse du problème </a>
            <input type="number" class="form-control m-1" name="Numero" placeholder="Numéro" required/>
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
                <input type="submit" value="Ajouter le problème" class="form-control bg-dark text-light" name="ajout"/>
            </div>
        </div>

</div>
</html>
