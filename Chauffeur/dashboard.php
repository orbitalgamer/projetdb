<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';



$chauffeur = new chauffeur();


function Afficher($liste){
    foreach ($liste as $auto) {
        if(empty($auto)){
            break;
        }
     
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <th>' . $auto["Id"] . '</th>
            <td>' . $auto["DateReservation"] . '</td>
            <td>' . $auto["Nom"] . '</td>
            <td>' . $auto["Prenom"] . '</td>
            <td>' . $auto["adresse_depart"] . '</td>
            <td>' . $auto["adresse_fin"] . '</td>
            <th>
            <form action="abandonner_course.php" method="post">
            <input type="hidden" name="Id" value="' . $auto["Id"] . '">
            <button type="submit" class="btn btn-outline-secondary">Abandonner course</button>
        </form>
     </tr>';
        echo $ligne;
    }
}
function AfficherEncours($liste){
    foreach ($liste as $auto) {
        if(empty($auto)){
            break;
        }
     
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <th>' . $auto["Id"] . '</th>
            <td>' . $auto["DateReservation"] . '</td>
            <td>' . $auto["Nom"] . '</td>
            <td>' . $auto["Prenom"] . '</td>
            <td>' . $auto["adresse_depart"] . '</td>
            <td>' . $auto["adresse_fin"] . '</td>
            <th>
            <form action="terminer_course.php" method="post">
            <input type="hidden" name="Id" value="' . $auto["Id"] . '">
            <button type="submit" class="btn btn-outline-secondary">Course terminée</button>
        </form>
     </tr>';
        echo $ligne;
    }
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste de vos courses à venir</p>
    </div>
        
    <div class="row align-items-center">
        <form class="col-md-3 form-group" action="affichetout.php">
            <input type="submit" value="Voir toutes vos courses" class="form-control bg-dark text-light" name="New"/>
        </form>
    
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">Id</th>
            <th scope="col h3">DateReservation</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Prenom</th>
            <th scope="col h3">Adresse Depart</th>
            <th scope="col h3">Adresse Fin</th>
            <th scope="col-md-1 h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php
            
            if(empty($_GET['search']) && empty($_GET['maitenance'])) {
                $all = $chauffeur->GetCoursetermine($_SESSION['Id']);
                AfficherEncours($all);
                $all = $chauffeur->GetCoursefutur($_SESSION['Id']);
                Afficher($all);
                
            }
            else{
                if(!empty($_GET['search'])){
                    $resultat = $chauffeur->Rechercherfutur($_SESSION['Id'],$_GET['search']);
                    Afficher($resultat);
                }

            }
            ?>
        </tbody>
    </table>
</div>
</html>
