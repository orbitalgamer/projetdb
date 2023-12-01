<?php

require_once 'Bdd.php';


/**
 * création classe chauffeur 
 */
class chauffeur
{
public $Id;
public $Nom;
public $Prenom;
public $Email;
public $Mdp;
public $NumeroDeTelephone;
public $IdStatus;
public $Bdd;


public function __construct(){
    $db = new Bdd();
    $this->Bdd=$db->getBdd();
}

    public function GetAll(){
        $req = $this->Bdd->query("
    SELECT DISTINCT personne.*   
    FROM  personne
    WHERE IdStatus = 2
    
    ");
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;
    }
    
    public function Getcourseold($Id){
        $req = $this->Bdd->prepare("
        SELECT DISTINCT
        course.*,
        personne.Nom,
        personne.Prenom,
        adresse_depart.Vile AS ville_depart,
        adresse_depart.Rue AS rue_depart,
        adresse_depart.Numero AS num_depart,
        adresse_fin.Vile AS ville_fin,
        adresse_fin.Rue AS rue_fin,
        adresse_fin.Numero AS num_fin
    FROM
        course
    JOIN personne ON personne.Id = course.IdClient
    JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
    JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
    WHERE
        course.IdChauffeur = :Id
        AND course.DateReservation < CURRENT_DATE;

    "); 
    $req->bindParam(':Id', $Id);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;
    
}
public function Getcoursefutur($Id){
    $req = $this->Bdd->prepare("
        SELECT DISTINCT
            course.*,
            personne.Nom,
            personne.Prenom,
            CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
            CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin
        FROM
            course
        JOIN personne ON personne.Id = course.IdClient
        JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
        JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
        WHERE
            course.IdChauffeur = :Id
            AND course.DateReservation > CURRENT_DATE;
    ");


    $req->bindParam(':Id', $Id);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;

}
    public function Getavis($Idchauffeur,$Idcourse){
        

        $req = $this->Bdd->prepare("
        SELECT DISTINCT
    course.*,
    personne.Nom,
    personne.Prenom,
    avis.note,
    avis.description
FROM
    course
JOIN personne ON personne.Id = course.IdClient
JOIN avis ON avis.IdCourse = course.Id
WHERE
    course.IdChauffeur = :Id
    AND course.Id = :Id_course;");
    $req->bindParam(':Id', $Idchauffeur);
    $req->bindParam(':Id_course', $Idcourse);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

    return $resultats;

}

}

?>