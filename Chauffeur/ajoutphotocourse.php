<?php
include_once 'navbar.php';
include_once '../classes/course.php';

//pour faire fonctionner sélection adresse

$course = new Course();



if(!empty($_GET)) {
    if (!empty($_GET['Id'])) {
        $Id = $_GET['Id'];

    } else {
        header('location: affichetout.php'); //si pas définit
    }
    if (!empty($_POST)) {

        //va transferer les photo
        function reArrayFiles($file_post)
        {
            $file_ary = array();
            $file_count = count($file_post['name']);
            $file_keys = array_keys($file_post);
            for ($i = 0; $i < $file_count; $i++) {
                foreach ($file_keys as $key) {
                    $file_ary[$i][$key] = $file_post[$key][$i];
                }
            }
            return $file_ary;
        }

        //mets photo dans ordre plus simple
        $img = reArrayFiles($_FILES['images']);
        $url = "../image/course/" . $Id;


        mkdir($url); //crée dossier pour tous les mettres déjà crée


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
                    $course->InsertPhoto("course/" . $Id . "/" . $a . "." . $ext, $Id); //ajoute dans la dB

                } else {
                    echo "<p class='alert alert-danger' role='alert'>" . $image['name'] . " - fichier non transféré<br>";
                }
            } else {
                echo "<p class='alert alert-danger' role='alert'>" . $image['name'] . " - fichier invalide<br>";
            }
            $a++;
        }

        header('location: ajoutphotocourse.php?Id=' . $Id);

    }
}
else{
    header('location: affichetout.php'); //si pas définit
}



?>

<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Ajouter des photos pour une course</p>
    </div>

    <div class="form-group">
        <p class="h4 pt-4">Vous pouvez ajouter des photos à une course au cas où des clients ont abimé l'auto.</p>
    </div>

    <form class="" method="POST" enctype="multipart/form-data">
        <div class="form-group h5">
            <a class="">Photo du véhicule<a>
                <span class="col-lg-8 col-sm-12 py-3">
                    <div class="d-flex flex-column px-3">
                        <div class="container-fluid  border bg-light mb-3 rounded">
                            <div class="row ">
                                <?php
                                $image = $course->GetPhoto($Id);

                                foreach($image as $img){
                                    $url = '../image/'.$img['CheminDAcces'];
                                    echo '       
                          <div class="item col-sm-6 col-md-6 align-items-center">
                          <a href="'.$url.'" class="fancybox" data-fancybox="gallery1">
                            <img class="img img-fluid pt-3 pb-3" src="'.$url.'">
                          </a>
                    </div>';
                                }
                                ?>
                        </div>
                    </div>
        </div>
  </span>
                    <input type="file" class="form-control" name="images[]" multiple="">

        </div>


        <div class="d-flex row">
            <div class="col-sm-4 justify-content-center">
                <input type="submit" value="modifier le problème" class="form-control bg-dark text-light" name="ajout"/>
            </div>
        </div>

</div>
</html>
