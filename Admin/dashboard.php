<?php
include_once 'navbar.php';
include_once '../classes/course.php';

$course = new Course();

$EnCours = $course->GetEncoure();
$Suivant = $course->GetSuivante();


?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Course en cours</p>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Chauffeur</th>
            <th scope="col h3">Nom Client</th>
            <th scope="col h3">Status</th>
            <th scope="col h3">Date debut</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        $compteur = 1;
        foreach ($EnCours as $elem) {

                $ligne = '<tr>';
            $ligne .= ' <th>' . $compteur . '</th>
            <td>' . $elem['NomChauffeur'] . '</td>
            <td>' . $elem["NomClient"] . '</td>
            <td>' . $elem["NomEtat"] . '</td>
            <td>' . $elem["DateReservation"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voircourse.php?Id=' . $elem["Id"] . '`">voir course</button></td>
     </tr>';
            echo $ligne;
            $compteur += 1;
        }
        ?>
        </tbody>
</table>
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Course suivantes</p>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Chauffeur</th>
            <th scope="col h3">Nom Client</th>
            <th scope="col h3">Date debut</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        $compteur = 1;
        foreach ($Suivant as $elem) {

            $ligne = '<tr>';
            $ligne .= ' <th>' . $compteur . '</th>
            <td>' . $elem['NomChauffeur'] . '</td>
            <td>' . $elem["NomClient"] . '</td>
            <td>' . $elem["DateReservation"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voircourse.php?Id=' . $elem["Id"] . '`">voir course</button></td>
     </tr>';
            echo $ligne;
            $compteur += 1;
        }
        ?>
        </tbody>
    </table>

<div>
</html>
