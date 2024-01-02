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
        <p class="display-4 pt-4 pb-2 bold">Courses en cours</p>
    </div>
    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Chauffeur</th>
            <th scope="col h3">Nom Client</th>
            <th scope="col h3">Statut</th>
            <th scope="col h3">Date Début</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        $compteur = 1;
        foreach ($EnCours as $elem) {

                $ligne = '<tr>';
            $ligne .= ' <td>' . $compteur . '</td>
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
        <p class="display-4 pt-4 pb-2 bold">Courses suivantes</p>
    </div>
    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Chauffeur</th>
            <th scope="col h3">Nom Client</th>
            <th scope="col h3">Date Début</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        $compteur = 1;
        foreach ($Suivant as $elem) {

            $ligne = '<tr>';
            $ligne .= ' <td>' . $compteur . '</td>
            <td>' . $elem['NomChauffeur'] . '</td>
            <td>' . $elem["NomClient"] . '</td>
            <td>' . $elem["DateReservation"] . '</td>
            <th><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voircourse.php?Id=' . $elem["Id"] . '`">voir course</button></th>
     </tr>';
            echo $ligne;
            $compteur += 1;
        }
        ?>
        </tbody>
    </table>

<div>
    <script>
        //pour trier dynamiquement table
        function  sortTableByColum(table, colmumn, asc=true){

            const dirModifier  = asc ? 1 : -1; //ordre de sort
            const tBody = table.tBodies[0];
            const rows = Array.from(tBody.querySelectorAll('tr')); //prend chaque élément




            //trillage
            const sortedRows = rows.sort( (a, b) => {

                const aColText = a.querySelector(`td:nth-child(${colmumn + 1})`).textContent.trim(); //prend leur élément à l'intérieur
                const bColText = b.querySelector(`td:nth-child(${colmumn + 1})`).textContent.trim(); //pareil pour le second

                return aColText>bColText ? (1*dirModifier) : (-1*dirModifier); //pour renovyer taille
            }); //méthode lambda

            //supprime les actue
            while(tBody.firstChild){
                tBody.removeChild(tBody.firstChild);
            }

            //rajoute les trier
            tBody.append(...sortedRows); //rajoute tous les rows dans le bon sens


            //rapeler comment actuellemnet c'est trier
            table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
            table.querySelector(`th:nth-child(${colmumn +1 })`).classList.toggle("th-sort-asc", asc); //rajouter si on a tirer par ça
            table.querySelector(`th:nth-child(${colmumn+1 })`).classList.toggle("th-sort-desc", !asc);

        }


        document.querySelectorAll(".table-sortable th").forEach(headerCell => {
            headerCell.addEventListener("click", () =>{
                const tableElement = headerCell.parentElement.parentElement.parentElement; //pour revnier à parent
                const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell); //pour avoir tous les index ou on peut cliquer
                const currentIsAcending = headerCell.classList.contains("th-sort-asc"); //pour dire que c'est asc si montant ou pas
                if(headerIndex <= 4) { //pour pas trier suivant avis et supprimer
                    sortTableByColum(tableElement, headerIndex, !currentIsAcending); //doit inverser pour changer de sens automatiquement
                }
            });
        });

    </script>

    <style>
        .table-sortable th{
            cursor: pointer;
        }

        .table-sortable .th-sort-asc::after{
            content: "\25b4";
        }

        .table-sortable .th-sort-desc::after{
            content: "\25be";
        }

        .table-sortable .th-sort-asc:after,.table-sortable .th-sort-desc:after{
            margin-left: 5px;
        }

        .table-sortable .th-sort-asc, .table-sortable .th-sort-desc{
            background: rgba(0,0,0,0.1);
        }
    </style>
</html>
