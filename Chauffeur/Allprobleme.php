<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';
include_once '../classes/course.php';


$chauffeur = new chauffeur();
$course = new course();


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
            <td>' . $auto["Idcourse"] . '</td>
            <td>' . $auto["CheminDacces"] . '</td>
        
            
     </tr>';
       
        echo $ligne;
        
    }
}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste de vos problemes</p>
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
            <th scope="col h3">DateReservation</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Prenom</th>
            <th scope="col h3">Idcourse</th>
            <th scope="col h3">Chemin D'acces</th>
          
            <th scope="col-md-1 h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php
            
            if(empty($_GET['search']) && empty($_GET['maitenance'])) {
                $all = $chauffeur->GetAllprobleme($_SESSION['Id']);
                Afficher($all);
            }
            else{
                if(!empty($_GET['search'])){
                    $resultat = $chauffeur->Rechercher($_GET['search']);
                    Afficher($resultat);
                }

            }
            ?>
        </tbody>
    </table>
</div>
</html>
