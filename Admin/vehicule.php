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
        $ligne .= ' <td>' . $auto["PlaqueVoiture"] . '</td>
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
    <table class="table table-sortable table-striped table-responsive-md">
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
            if(headerIndex <= 7) { //pour pas trier suivant avis et supprimer
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
