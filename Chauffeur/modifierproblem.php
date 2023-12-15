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
        $Id = $_GET['Id'];
        $info = $probleme->GetId($Id);
        $infoAdresse = $adresse->GetInfo($info['IdAdresse']);
    }
    else{
        header('location: Allprobleme.php'); //si pas définit
    }
    if(!empty($_POST)){
        $adresse->Rue =strtolower( $_POST['Rue']);
        $adresse->Ville = strtolower($_POST['Ville']);
        $adresse->Numero = $_POST['Numero'];
        $adresse->CP = $_POST['CP'];

        $IdAdresse = $adresse->GetAdresse(); //cherche adresse

        if(empty($IdAdresse)){ //si existe pas
            $adresse->latitude =1; //osef latidue pour adresse
            $adresse->longitude =1;

            $adresse->creation();//crée adresse si existe pas
        }
        $IdAdresse = $adresse->GetAdresse()[0]; //recherche l'Id de la nouvelle adresse créer

        $probleme->Description = $_POST['Description'];
        $probleme->Rouler = $_POST['Rouler'];
        $probleme->IdTypeProbleme = $_POST['TypeProbleme'];
        $probleme->IdAdresse = $IdAdresse;
        $probleme->IdCourse = $Id;

        if($probleme->Update($Id) == array("succes"=>1)){

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

            //mets photo dans ordre plus simple
            $img=reArrayFiles($_FILES['images']);
            $url="../image/probleme/".$Id;


            mkdir($url); //crée dossier pour tous les mettres déjà crée


            $a=0;
            foreach($img as $image){
                if($image['error']){
                    echo "<p class='alert alert-danger' role='alert'>".$image['name']." - ".$erreur[$image['error']]."<br>";
                }
                $b=explode('.', $image['name']);
                $c=end($b);
                $ext=strtolower($c);
                $aut=array('bmp', 'tiff', 'jpeg', 'jpg', 'gif', 'png', 'svg', 'tif');
                if(in_array($ext, $aut)){

                    if(move_uploaded_file($image['tmp_name'], $url."/".$a.".".$ext)){
                        //echo "<p class='alert alert-success' role='alert'>".$image['name']." - fichier transferé<br>";
                        //echo $_SESSION['IdPa'] ." ".$ext." ".$a."<br>";
                        $probleme->InsertPhoto("probleme/".$Id."/".$a.".".$ext, $Id); //ajoute dans la dB

                    }
                    else{
                        echo "<p class='alert alert-danger' role='alert'>".$image['name']." - fichier non transféré<br>";
                    }
                }
                else{
                    echo "<p class='alert alert-danger' role='alert'>".$image['name']." - fichier invalide<br>";
                }
                $a++;
            }

            header('location: modifierproblem.php?Id='.$Id);
        }
        else{
            echo 'erreur ajout';
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
        <p class="display-4 pt-4 pb-2 bold">Modifier un problème</p>
    </div>

    <form class="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="probleme" class="h5">Type accident</label>
            <select class="form-control h5" id="probleme" name="TypeProbleme">
                <?php

                $typeprobleme = $probleme->GetAllType();

                foreach ($typeprobleme as $elem) {
                    if($elem["Nom"] == $info["NomProbleme"]){
                        echo ' <option selected="selected" value="' . $elem["Id"] . '">' . $elem["Nom"] . '</option>';
                    }
                echo ' <option value="' . $elem["Id"] . '">' . $elem["Nom"] . '</option>';
                }

                ?>

            </select>
        </div>
        <div class="form-group">
            <a class="h5">Description</a>
            <textarea class="form-control" name="Description" placeholder="description" rows="6" required><?php echo $info['Description'] ?> </textarea>
        </div>

        <div class="form-group">
            <label for="rouler" class="h5" name="Rouler"/>Peut rouler</label>
            <select class="form-control" id="rouler" name="Rouler">
                <?php
                    if(info['Rouler'] == 1){
                        echo ' <option  value="0"> Non</option>
                <optionselected="selected" value="1">Oui</option>';
                    }
                    else{
                        echo '<option selected="selected" value="0"> Non</option>
                <option value="1">Oui</option>';
                    }
                ?>


            </select>
        </div>

        <div class="form-group h5">
            <a class="">Adresse de l'accident</a>
            <input type="number" class="form-control m-1" name="Numero" value="<?php echo $infoAdresse['Numero']; ?>" required/>
            <input type="text" class="form-control m-1" name="Rue" value="<?php echo $infoAdresse['Rue']; ?>" required/>
            <input type="number" class="form-control m-1" name="CP" value="<?php echo $infoAdresse['CodePostal']; ?>" required/>
            <input type="text" class="form-control m-1" name="Ville" value="<?php echo $infoAdresse['Vile']; ?>" required/>
        </div>

        <div class="form-group h5">
            <a class="">Photo du problème<a>
                <span class="col-lg-8 col-sm-12 py-3">
                    <div class="d-flex flex-column px-3">
                        <div class="container-fluid  border bg-light mb-3 rounded">
                            <div class="row ">
                                <?php
                                $image = $probleme->GetPhoto($Id);

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
