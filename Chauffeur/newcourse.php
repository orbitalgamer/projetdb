<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';



$chauffeur = new chauffeur();


function Afficher($liste){
    $compteur = 1;
    foreach ($liste as $auto) {
        if(empty($auto)){
            break;
        }
     
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <th>' . $compteur . '</th>
        <td>' . $auto["DateReservation"] . '</td>
        <td>' . $auto["PlaqueVehicule"] . '</td>
        <td>' . $auto["Nom"] ." ".$auto["Prenom"] . '</td>
        <td>' . $auto["adresse_depart"] . '</td>
        <td>' . $auto["adresse_fin"] . '</td>
        <th>
        <form action="accepter_course.php" method="post">
            <input type="hidden" name="Id" value="' . $auto["Id"] . '">
            <button type="submit" class="btn btn-outline-secondary">Accepter course</button>
        </form>
        </form>
        </th> </tr>';
        $compteur +=1;
        echo $ligne;
    }
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des courses à prendre</p>
    </div>
        
    <div class="row align-items-center">
    
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">DateReservation</th>
            <th scope="col h3">Plaque</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Adresse Depart</th>
            <th scope="col h3">Adresse Fin</th>
            <th scope="col-md-1 h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php
            
            if(empty($_GET['search']) && empty($_GET['maitenance'])) {
                $all = $chauffeur->GetnewCourse();
                Afficher($all);
            }
            else{
                if(!empty($_GET['search'])){
                    $resultat = $chauffeur->RechercherAcceptation($_GET['search']);
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
            if(headerIndex <= 5) { //pour pas trier suivant avis et supprimer
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
