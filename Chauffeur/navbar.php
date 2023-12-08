<?php
session_start(); //démarre session ici doit plus le faire par après

if(!empty($_SESSION['Id'])){
    if(empty($_SESSION['Nom']) || empty($_SESSION['Prenom']) || empty($_SESSION['Role'])) {
        header('location: ../deconnection.php'); //le déconnecte car forçage connection par extérieur
        echo 'essaye de rentrer dans système';
    }
    elseif ($_SESSION['Role'] != 'Chauffeur'){
        echo 'pas droit admin';
        header('location:../index.php');
    }
}
else{
    header('location: ../index.php');
}
?>

<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="dashboard.php">Taxeasy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="newcourse.php">Ajouter des Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vehicule.php">Véhicule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Allprobleme.php">Vos Problèmes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="chauffeur.php">Chauffeurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="client.php">Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="avis.php">Avis</a>
            </li>
        </ul>
    </div>
        <div class="d-flex row">
        <div class="navbar-item col-md-8 navbar-text text-md-right pl-0 pr-0">
            <a class="nav-link">Bonjour, <?php echo $_SESSION['Prenom']; ?></a>
        </div>
        <div class="navbar-item col-md-4 navbar-text pl-0 pr-0">
            <a class="nav-link" href="../deconnection.php">Déconnection</a>
        </div>
        </div>
    </div>
</nav>

</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
