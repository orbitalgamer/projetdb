<?php

include_once "../Bdd.php";


if(!empty($_POST['Email']) && !empty($_POST['Mdp'])){
    $req=$Bdd->prepare("SELECT personne.Id, personne.Mdp, typepersonne.NomTitre as 'titre' FROM personne JOIN typepersonne on typepersonne.Id = personne.IdStatus WHERE personne.Email = :email");
    $req->bindParam(':email', $_POST['Email']);
    $req->execute();
    if($rep=$req->fetch()){
        if(password_verify($_POST['Mdp'], $rep['Mdp'])) {
            $_SESSION['Id'] = $rep['Id'];
            $_SESSION['Role'] = $rep['titre'];
            header("location: ../Index.php");
        }
        else{
            header("location: ../index.php?error=1");
        }
    }   
    else{
        header("location: ../index.php?error=1");
    }
}
else{
     header("location: ../index.php?error=1");
}
/*

error 4 : mdp et login pas bon
*/
?>