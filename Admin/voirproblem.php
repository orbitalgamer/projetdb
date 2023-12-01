<?php
include_once 'navbar.php';

if(!empty($_GET['Id'])){
    $Id=$_GET['Id']; // prend l'id du problème
}
else{
    header('location: probleme.php');
}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Consultation d'un problème</p>
    </div>
    


</div>
</html>
