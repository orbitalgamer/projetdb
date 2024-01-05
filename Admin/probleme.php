<?php
include 'navbar.php';
include '../classes/probleme.php';

$prob = new probleme();
if(!empty($_GET['search'])){
    $liste = $prob->Recherche($_GET['search']);
}else {
    $liste = $prob->GetAll();
}
if(!empty($_GET['search'])){

}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des problèmes liés aux véhicules</p>
    </div>
    <div class="row align-items-center">
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher : plaque, type problème, Nom" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">Plaque</th>
            <th scope="col h3">Type Problème</th>
            <th scope="col h3">Véhicule Fonctionnel</th>
            <th scope="col h3">Maintenance Prévue</th>
            <th scope="col h3">Problème Réglé</th>
            <th scope="col-md-1 h3"></th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php
        foreach ($liste as $elem){
            if(!$elem['Regle'] && $elem['MaitenancePrevu'] == 'Non'){
                $ligne = '<tr class="table-danger">';
            }
            else{
                $ligne = '<tr>';
            }

            $ligne .= '
                        <td>'.$elem["Plaque"].'</td>
                        <td>'.$elem["NomProbleme"].'</td>
                        <td>'.$elem["Rouler"].'</td>
                        <td>'.$elem["MaitenancePrevu"].'</td>
                        <td>'.$elem["Regle"].'</td>
                        <th><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voirproblem.php?Id=' . $elem["Id"] . '`">voir en détail</button></th>
            ';
            echo $ligne;
        }

        ?>

        </tbody>
    </table>
</div>
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
