<?php
include_once 'navbar.php';

include_once '../classes/course.php';

$course = new course();

if(empty($_GET['search'])) {
    $resultats = $course->GetAll();
}
else{
    $resultats = $course->Requete($_GET['search']);
}

function Afficher($liste){
    $compteur = 1;
    foreach ($liste as $elem) {
        if($elem['Inpaye'] == 0) {
            $ligne = '<tr class="table-danger">'; //pour mettre en évidence ceux qui ont problème
        }
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <th>' . $compteur . '</th>
            <td>' . $elem['NomChauffeur'] . '</td>
            <td>' . $elem["NomClient"] . '</td>
            <td>' . $elem["DistanceParcourue"] . '</td>
            <td>' . $elem["NomEtat"] . '</td>
            <td>' . $elem["Inpaye"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`facture.php?Id=' . $elem["Id"] . '`">voir facture</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voircourse.php?Id=' . $elem["Id"] . '`">voir course</button></td>
     </tr>';
        echo $ligne;
        $compteur += 1;
    }
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Courses</p>
    </div>
    <div class="row align-items-center">

        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher : Nom, Status" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Chauffeur</th>
            <th scope="col h3">Nom Client</th>
            <th scope="col h3">Distance parcourue</th>
            <th scope="col h3">Status</th>
            <th scope="col h3">Payé</th>
            <th scope="col h3">Facture</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        Afficher($resultats);
        ?>
        </tbody>
    </table>
</div>
</html>
