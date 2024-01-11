<?php


include_once '../classes/course.php';
include_once '../classes/avis.php';

$course = new course();
$avis = new avis();

if(empty($_GET['Id'])){
    header('location: /client/paiement.php');
}
$Id=$_GET['Id'];
$course->Get($Id);

if(empty($course)){
    header('location: paiement.php');
}

if(!empty($_POST['Note']) && !empty($_POST['Description'])){
    $avis->IdCourse = $Id;
    $avis->Description=$_POST['Description'];
    $avis->Note = (int) $_POST['Note'];
    $avis->MettreAvis();

    header('location: paiement.php');
}




?>
<?php

?>


<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue': '#1e3a8a',
                        'black': '#030712',
                        'green': '#84cc16',
                        'white': '#FAF9F6'
                    },
                    height: {
                        '96': '64rem'
                    },
                    boxShadow: {
                        'base': "rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset"
                    }
                }
            }
        }
    </script>

</head>
<nav class="bg-black h-12">
    <div class="mx-auto max-w-7xl max-h-7xl px-2 sm:px-6 lg:px-8">
        <div class="flex flex-row space-x-24 items-center">

            <a href="index.php" class="text-gray-300 text-2xl font-weight">TAXEASY</a>


            <a href="index.php" class="text-white font-medium shadow-2xl hover:text-slate-300">à propos</a>
            <a href="paiement.php" class="text-white font-medium shadow-2xl  hover:text-slate-300">Vos historiques de courses</a>
            <!-- <a href="../index.php" class="text-white font-medium shadow-2xl">à propos</a> -->

            <a href="deconnection.php" class="text-white font-medium shadow-2xl  hover:text-slate-300">Deconnexion</a>

        </div>

    </div>
</nav>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Mettre un avis</p>
    </div>

    <form class="" method="POST">
        <div class="form-group">
            <label for="Note" class="h5" name="Note"/>Notes</label>
            <input type="number" class="form-control" min="0" max="5" step="0.5" name="Note" placeholder="Note" required>

        </div>
        <div class="form-group">
            <a class="h5">Description</a>
            <textarea class="form-control" name="Description" placeholder="description" rows="6" required> </textarea>
        </div>



        <div class="d-flex row">
            <div class="col-sm-4 justify-content-center">
                <input type="submit" value="Ajouter l'avis" class="form-control bg-dark text-light" name="ajout"/>
            </div>
        </div>
    </form>



</div>


</html>
