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
    SELECT DISTINCT course.*, personne.Nom, personne.Prenom
    FROM  course, personne
    WHERE course.IdChauffeur =  :Id 
    AND personne.Id = course.IdClient
    AND course.DateReservation < CURRENT_DATE
    
    "); 
    $req->bindParam(':Id', $Id);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;
    
}
    public function Getcoursefutur($Id){
        $req = $this->Bdd->prepare("
    SELECT DISTINCT course.*, personne.Nom, personne.Prenom
    FROM  course, personne
    WHERE course.IdChauffeur =  :Id 
    AND personne.Id = course.IdClient
    AND course.DateReservation > CURRENT_DATE

    "); 
    $req->bindParam(':Id', $Id);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;

}
    public function Getavis($IdChauffeur, $Idcourse){
     
        $req = $this->Bdd->prepare("
        SELECT DISTINCT course.*, personne.Nom, personne.Prenom, avis.note, avis.description
        FROM course, personne, avis
        WHERE course.IdChauffeur = :Id 
        AND personne.Id = course.IdClient
        AND avis.IdCourse = course.Id_course
        AND course.Id = :Id_course
");
    $req->bindParam(':Id', $IdChauffeur);
    $req->bindParam(':Id_course', $Idcourse);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;

}

}

?>