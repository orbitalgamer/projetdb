<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';

$voit = new chauffeur();
$resultats = $voit->GetAll();

function Afficher($liste){
    foreach ($liste as $auto) {
        if(empty($auto)){
            break;
        }
     
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <th>' . $auto["Id"] . '</th>
            <td>' . $auto["Nom"] . '</td>
            <td>' . $auto["Prenom"] . '</td>
            <td>' . $auto["Email"] . '</td>
            <td>' . $auto["NumeroDeTelephone"] . '</td>
     </tr>';
        echo $ligne;
    }
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Chauffeurs</p>
    </div>
    <div class="row align-items-center">
    
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">Id</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Prenom</th>
            <th scope="col h3">Email</th>
            <th scope="col h3">NumeroDeTelephone</th>
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
