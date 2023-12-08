<?php
include_once 'navbar.php';

include_once '../classes/avis.php';

$avisObjet = new avis();
if(!empty($_GET['search'])) {
    $resultats = $avisObjet->Requette($_GET['search']);
}
elseif (!empty($_GET['Filtre'])){ //pour filtre
    if($_GET['Min'] <= $_GET['Max']){
        $resultats = $avisObjet->RequetteNote($_GET['Min'], $_GET['Max']);
    }
    else {
        header('location: avis.php');
    }
}
else{
    $resultats = $avisObjet->GetAll();

}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Chauffeurs</p>
    </div>
    <div class="row align-items-center">

        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher Nom, Prenom" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
        <form class="col-md-8 form-group" action="" method="">
            <div class="container">
                <div class="row">
                    <a class="h4 col-md-2">note de</a>
                    <input type="number" step="any" class="form-control rounded col-md-2 pr-4" min="0" name="Min" placeholder="min" aria-label="min" aria-describedby="inputGroup-sizing-sm" required/>
                    <input type="number" step="any" class="form-control rounded col-md-2 pr-4" min="0" name="Max" placeholder="max" aria-label="max" aria-describedby="inputGroup-sizing-sm" required/>
                    <input type="submit" class="form-control rounded bg-dark text-white col-md-3" name="Filtre" value="Filtrer" aria-label="max" aria-describedby="inputGroup-sizing-sm"/>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Client</th>
            <th scope="col h3">Chauffeur</th>
            <th scope="col h3">Plaque</th>
            <th scope="col h3">Note</th>
            <th scope="col h3">Description</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        $compteur = 1;
        foreach($resultats as $elem) {
            if($elem['Note'] <=2.5){
                $ligne = '<tr class="table-danger">';
            }
            else{
                $ligne = '<tr>';
            }
            $ligne .= '<th>' . $compteur . '</th>
            <td>' . $elem['NomClient'].' '.$elem['PrenomClient'] . '</td>
            <td>' . $elem['NomChauffeur'].' '.$elem['PrenomChauffeur'] . '</td>
            <td>' . $elem["plaque"] . '</td>
            <td>' . $elem["Note"] . '</td>
            <td>' . substr($elem["Description"],0,20) . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voiravis.php?Id=' . $elem["Id"] . '`">voir au complet</button></td>
     </tr>';
            echo $ligne;
            $compteur += 1;
        }
        ?>
        </tbody>
    </table>
</div>
</html>