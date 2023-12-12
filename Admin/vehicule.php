<?php
include_once 'navbar.php';

include_once '../classes/vehicule.php';


$voit = new vehicule();

function Afficher($liste){
    foreach ($liste as $auto) {
        if(empty($auto)){
            break;
        }
        if($auto['problem'] == 1) {
            $ligne = '<tr class="table-danger">'; //pour mettre en évidence ceux qui ont problème
        }
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <th>' . $auto["PlaqueVoiture"] . '</th>
            <td>' . $auto["Modele"] . '</td>
            <td>' . $auto["NomCarburant"] . '</td>
            <td>' . $auto["Kilometrage"] . '</td>
            <td>' . $auto["PMR"] . '</td>
            <td>' . $auto["Autonome"] . '</td>
            <td>' . $auto["PrixDernier"] . '</td>
            <th><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`modificationVehicule.php?Id=' . $auto["PlaqueVoiture"] . '`">voir plus</button></th> </tr>';
        echo $ligne;
    }
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des véhicules</p>
    </div>
    <div class="row align-items-center">
        <form class="col-md-2 form-group" action="modificationvehicule.php">
            <input type="submit" value="ajouter vehicule" class="form-control bg-dark text-light" name="New"/>
        </form>
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher plaque, PMR, Autnome, ..." aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">Plaque</th>
            <th scope="col h3">Modele</th>
            <th scope="col h3">Carburant</th>
            <th scope="col h3">killométrage</th>
            <th scope="col h3">PMR</th>
            <th scope="col h3">Autonome</th>
            <th scope="col h3">Tarrif (€/km)</th>
            <th scope="col-md-1 h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php
            if(empty($_GET['search']) && empty($_GET['maitenance'])) {
                $all = $voit->GetAll();
                Afficher($all);
            }
            else{
                if(!empty($_GET['search'])){
                    $resultat = $voit->Rechercher($_GET['search']);
                    Afficher($resultat);
                }

            }
            ?>
        </tbody>
    </table>
</div>
</html>
