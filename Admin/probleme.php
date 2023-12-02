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
        <p class="display-4 pt-4 pb-2 bold">Liste des problèmes lies au véhicule</p>
    </div>
    <div class="row align-items-center">
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">Plaque</th>
            <th scope="col h3">Type de problème</th>
            <th scope="col h3">Peut rouler</th>
            <th scope="col h3">Maintenance prevue</th>
            <th scope="col h3">Reglé</th>
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
                        <th>'.$elem["Plaque"].'</th>
                        <th>'.$elem["NomProbleme"].'</th>
                        <th>'.$elem["Rouler"].'</th>
                        <th>'.$elem["MaitenancePrevu"].'</th>
                        <th>'.$elem["Regle"].'</th>
                        <td><button type="button" class="btn btn-outline-secondary bg-dark text-white" onclick="window.location.href=`voirproblem.php?Id=' . $elem["Id"] . '`">voir en détail</button></td>
            ';
            echo $ligne;
        }

        ?>

        </tbody>
    </table>
</div>
</html>
