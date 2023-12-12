<?php
include_once 'navbar.php';
include_once '../classes/vehicule.php';
include_once '../classes/probleme.php';
if(!empty($_GET['New'])) {
    $Id = -2; //si on a cette id, on sait que c'est pour ajouter
}
if(!empty($_GET['Id'])){
    $Id = $_GET['Id']; //pour avoir id
}

$voiture = new vehicule(); //objet pour avoir les info de la voiture
$prob = new probleme();

if(!empty($_POST)){
    if(!empty($_POST['ajout'])){ //si c'est bien pour ajouter
        $voiture->PlaqueVoiture = $_POST['plaque'];
        $voiture->Marque = $_POST['marque'];
        $voiture->Modele = $_POST['modele'];
        $voiture->Kilometrage = $_POST['killometrage'];
        $voiture->Couleur = $_POST['couleur'];
        $voiture->Annee = $_POST['Annee'];
        $voiture->Carburant = $_POST['Caruburant'];
        $voiture->PlaceDisponible = $_POST['PlaceDisponible'];
        $voiture->PMR = $_POST['PMR'];
        $voiture->Autonome = $_POST['Autonome'];
        $retour =$voiture->Insert();
        if($retour == array('succes'=>'1')){
            header('location:vehicule.php');
        }

    }
    if(!empty($_POST['modif'])){ //si c'est bien pour ajouter
        $voiture->PlaqueVoiture = $_POST['plaque'];
        $voiture->Marque = $_POST['marque'];
        $voiture->Modele = $_POST['modele'];
        $voiture->Kilometrage = $_POST['killometrage'];
        $voiture->Couleur = $_POST['couleur'];
        $voiture->Annee = $_POST['Annee'];
        $voiture->Carburant = $_POST['Caruburant'];
        $voiture->PlaceDisponible = $_POST['PlaceDisponible'];
        $voiture->PMR = $_POST['PMR'];
        $voiture->Autonome = $_POST['Autonome'];
        $retour =$voiture->Update();
        if($retour == array('succes'=>'1')){
            header('location:modificationvehicule.php?Id='.$Id);
        }
    }
    if(!empty($_POST['NewPrix'])){ //si c'est bien pour ajouter
        $retour =$voiture->NewPrix($_POST['prix'], $Id);
        if($retour == array('succes'=>'1')){

        }

    }
    if(!empty($_POST['Suppression'])){ //si c'est bien pour supprimer
        $retour =$voiture->Delete($Id);
        if($retour == array('succes'=>'1')){
            header('location: vehicule.php');
        }

    }
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold"> <?php
            if($Id == -2){
              echo "Ajouter un véhicule";
            }
            else{
                echo "voir véhicule";
            }
            ?></p>

        <?php
        if (isset($retour) && !empty($retour['error'])){

            echo "<p class='h4  alert alert-danger'>Ce véhicule existe déjà </p>";
        }
        ?>
    </div>

    <?php //pour form ajoute véhicule
    if($Id == -2) {
        $stirng = '
    
        <form class="" method="POST">
        <div class="form-group">
            <label class="h5" for="plaque">Plaque du véhicule</label>
            <input type="text" class="form-control" name="plaque" placeholder="plaque du vehicule" required/>
        </div>
        <div class="form-group">
            <label for="marque" class="h5">Marque</label>
            <input type="text" class="form-control" name="marque" placeholder="marque du vehicule" required/>
        </div>
        <div class="form-group">
            <a class="h5">Modèle</a>
            <input type="text" class="form-control" name="modele" placeholder="modele" required/>
        </div>
        
        <div class="form-group">
            <a class="h5">Killometrage</a>
            <input type="number" class="form-control" name="killometrage" placeholder="killometrage" required/>
        </div>
        
        
        
        <div class="form-group">
            <a class="h5">Couleur</a>
            <input type="text" class="form-control" name="couleur" placeholder="couleur" required/>
        </div>
        
        <div class="form-group">
            <a class="h5">Annee</a>
            <input type="number" class="form-control" name="Annee" placeholder="Annee" required/>
        </div>
        <div class="form-group">
            
            <label for="carburant" class="h5">Carburant</label>
          <select class="form-control h5" id="carburant" name="Caruburant">';

        $typecarburant = $voiture->GetTypeCarburant();

        foreach ($typecarburant as $elem) {
            $stirng .= ' <option value="' . $elem["Id"] . '">' . $elem["Nom"] . '</option>';
        }

        $stirng .= '
            
        </select>
        </div>
        <div class="form-group h5">
            <a class="">Place disponible</a>
            <input type="number" class="form-control" name="PlaceDisponible" placeholder="Place disponible" required/>
        </div>
        <div class="form-group">
            
            <label for="PMR" class="h5" name="PMR"/>Adapté au personne a mobilité réduite</label>
            <select class="form-control" id="PMR" name="PMR">
                <option selected="selected" value="0"> Non</option>
                <option value="PMR">Oui</option>
            </select>
        </div>
        
         <div class="form-group">
            
            <label for="PMR" class="h5" name="PMR"/>Autonome</label>
            <select class="form-control" id="Autonome" name="Autonome">
                <option selected="selected" value="Non"> Non</option>
                <option value="Autonome">Oui</option>
            </select>
        </div>
        
        <div class="d-flex row">
            <div class="col-sm-4 justify-content-center">
                <input type="submit" value="ajouter vehicule" class="form-control bg-dark text-light" name="ajout"/>
            </div>
        </div>
    
    </form>';

        echo $stirng;
    }
    else {
        //form pour afficher
        $info = $voiture->GetInfo($Id);

        if(!empty($info)) {
            //récupère info
            $stirng = '
    
        <form class="" method="POST">
        <div class="form-group">
            <label class="h5" for="plaque">Plaque du véhicule</label>
            <input type="text" class="form-control" name="plaque" value="' . $info["PlaqueVoiture"] . '" required/>
        </div>
        <div class="form-group">
            <label for="marque" class="h5">Marque</label>
            <input type="text" class="form-control" name="marque" value="' . $info["Marque"] . '" required/>
        </div>
        
        <div class="form-group">
            <a class="h5">Modèle</a>
            <input type="text" class="form-control" name="modele" value="' . $info["Modele"] . '" required/>
        </div>
        
        <div class="form-group">
            <a class="h5">Killometrage</a>
            <input type="number" class="form-control" name="killometrage" value="' . $info["Kilometrage"] . '" required/>
        </div>
        
        
        
        <div class="form-group">
            <a class="h5">Couleur</a>
            <input type="text" class="form-control" name="couleur" value="' . $info["Couleur"] . '" required/>
        </div>
        
        <div class="form-group">
            <a class="h5">Annee</a>
            <input type="number" class="form-control" name="Annee" value="' . $info["Annee"] . '" required/>
        </div>
        <div class="form-group">
            
            <label for="carburant" class="h5">Carburant</label>
          <select class="form-control h5" id="carburant" name="Caruburant">';

            $typecarburant = $voiture->GetTypeCarburant();

            foreach ($typecarburant as $elem) {
                if ($elem['Id'] != $info['Carburant']) {
                    $stirng .= ' <option value="' . $elem["Id"] . '">' . $elem["Nom"] . '</option>';
                } else {
                    $stirng .= ' <option value="' . $elem["Id"] . '" selected>' . $elem["Nom"] . '</option>';
                }
            }

            $stirng .= '
            
        </select>
        </div>
        <div class="form-group h5">
            <a class="">Place disponible</a>
            <input type="number" class="form-control" name="PlaceDisponible" value="' . $info["PlaceDisponible"] . '" required/>
        </div>
        <div class="form-group">
            
            <label for="PMR" class="h5" name="PMR"/>Adapté au personne a mobilité réduite</label>
            <select class="form-control" id="PMR" name="PMR">';

            if ($info['PMR'] == 'PMR') {
                $stirng .= '<option selected="selected" value="PMR"> Oui</option>
                <option value="0">non</option>';
            } else {
                $stirng .= '<option selected="selected" value="0"> Non</option>
                <option value="PMR">Oui</option>';
            }

            $stirng .= '

                
            </select>
        </div>
        
        <div class="form-group">
            
            <label for="Autonome" class="h5" name="Autonome"/>Autonome</label>
            <select class="form-control" id="Autonome" name="Autonome">';

            if ($info['Autonome'] == 'Autonome') { //sauvgerarde en texte ainsi peut juster noté autonome dans bar de recherche
                $stirng .= '<option selected="selected" value="Autonome"> Oui</option>
                <option value="Non">non</option>';
            } else {
                $stirng .= '<option selected="selected" value="Non"> Non</option>
                <option value="Autonome">Oui</option>';
            }


        $stirng .= '
                    </select>   
                </div>
                <div class="d-flex row">
            <div class="col-sm-4 justify-content-center">
                <input type="submit" value="modifier le vehicule" class="form-control bg-dark text-light" name="modif"/>
            </div>
        </div>
    
    </form>';

            //affichage historique des prix
            echo $stirng;
            $allPrix = $voiture->GetAllPrix($Id);
            $stirng = '
        <form class="pt-4" method="POST">
            <div class="form-group">
                <a class="h4 pb-2">Historique des prix </a>
                <div class="d-flex justify-content-center">
                <table class=" table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col-2 h3">#</th>
            <th scope="col-2 h3 data-with">Prix</th>
            <th scope="col-2 h3">Date changement</th>
        </tr>
        <tbody class="table-group-divider"';
            $a = 1;

        foreach ($allPrix as $prix){
            $stirng .='<tr> <th>' . $a . '</th>
            <td>' . $prix["PrixAuKilometre"] . '</td>
            <td>' . $prix["Date"] . '</td> </tr>';
            $a += 1;
        }

        $stirng .= '
        <tr>
        <th>'.($a).'</th>
        <th><input type="number" min="0" step=any class="form-control" name="prix" placeholder="Nouveau prix ?"  required/></th>
        <th> <input type="submit" class="form-control bg-dark text-light ms-0" name="NewPrix" value="Enregistrer"/></th>
        </tr>
        </thead>   
        </tbody>
    </table>
        </div>
                </div>
        </form>';
            echo $stirng;
            //affichage tous les accidents
            $accident = $prob->GetAccident($Id);
            $c = count($accident);
            $stirng ='<form class="pt-4" method="POST">
            <div class="form-group">
                <a class="h4 pb-2">Historique des accidents </a>
                <div class="d-flex justify-content-center">
                <table class=" table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col-2 h3">#</th>
            <th scope="col-2 h3 data-with">TypeAccident</th>
            <th scope="col-2 h3">Peut rouler</th>
            <th scope="col-2 h3">Regler</th>
            <th scope="col-2 h3">Maintenance Prevu</th>
            <th scope="col-2 h3"></th>
        </tr>
        </thead>
        <tbody class="table-group-divider"';
            foreach ($accident as $elem){
                if($elem['Regle'] == 0 && $elem['MaitenancePrevu'] == 0){
                    $stirng .='<tr class="table-danger">';
                }
                else{
                    $stirng .='<tr>';
                }
                $stirng .='<th>' . $c . '</th>
            <td>' . $elem["NomProbleme"] . '</td>
            <td>' . $elem["Rouler"] . '</td>
            <td>' . $elem["Regle"] . '</td>
            <td>' . $elem["MaitenancePrevu"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voirproblem.php?Id=' . $elem["Id"] . '`">voir plus</button></td> </tr>';
                $c -= 1;
            }

            $stirng .='</tbody> </table> </div> </div> </form>';
            echo $stirng;

            //affichage pour suppression

            $stirng = '
                    <form class="alert-danger p-2" method="POST">
                        <a class="h4 pb-3">Supperimer le véhicule</a>
                        <div class="container justify-content-center pb-2">
                            <label class="h5" for="plaque">Entrer supprimer pour supprimer le véhicule</label>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <input type="text" class="form-control" name="plaque" placeholder="supprimer" required/>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" class="form-control bg-dark text-light ms-0" name="Suppression" value="Supprimer"/>
                                </div>
                            </div>
                        </div>
                        </form>';
            //remarque peut supprimer car configure pour pas supprimer en cascade donc perd juste auto mais ne perd pas le reste. je veux dire par là que va garder tarification donc pourra toujous savoir combien ont payé client en tarif
            echo $stirng;
        }
        else{
            //voiure existe pas
            header('location: vehicule.php');
        }
    }


    ?>
</div>
</div>
</html>