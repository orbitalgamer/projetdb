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

        CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
        CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin

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

public function GetAllprobleme($Idchauffeur){
        

    $req = $this->Bdd->prepare("
    SELECT DISTINCT
course.Id AS Idcourse,
course.DateReservation,
personne.Nom,
personne.Prenom,
photocourse.Id,
photocourse.CheminDacces
FROM
course
JOIN personne ON personne.Id = course.IdClient
JOIN photocourse ON photocourse.IdCourse = course.Id
WHERE
course.IdChauffeur = :Id");
$req->bindParam(':Id', $Idchauffeur);
$req->execute();
$resultats = $req->fetchAll(PDO::FETCH_ASSOC);

return $resultats;

}
public function Getprobleme($Idchauffeur,$Idcourse){
        

    $req = $this->Bdd->prepare("
    SELECT DISTINCT
course.*,
personne.Nom,
personne.Prenom,
photocourse.Id,
photocourse.CheminDacces
FROM
course
JOIN personne ON personne.Id = course.IdClient
JOIN photocourse ON photocourse.IdCourse = course.Id
WHERE
course.IdChauffeur = :Id
AND course.Id = :Id_course;");
$req->bindParam(':Id', $Idchauffeur);
$req->bindParam(':Id_course', $Idcourse);
$req->execute();
$resultats = $req->fetchAll(PDO::FETCH_ASSOC);

return $resultats;

}

public function Rechercher($Idchauffeur, $query){
    
    $query = '%'.$query.'%';

    $req = $this->Bdd->prepare("
        SELECT DISTINCT 
            course.*,
            personne.Nom,
            personne.Prenom,
            adresse_depart.vile AS adresse_depart,
            adresse_fin.vile AS adresse_fin,
            avis.note,
            avis.description
        FROM course
        LEFT JOIN personne ON personne.Id = course.IdClient
        LEFT JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
        LEFT JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
        LEFT JOIN avis ON avis.IdCourse = course.Id
        WHERE
        (
            course.Id LIKE :query
            OR personne.Nom LIKE :query
            OR personne.Prenom LIKE :query
            OR adresse_depart.vile LIKE :query
            OR adresse_fin.vile LIKE :query
            OR course.DateReservation LIKE :query
            OR avis.note LIKE :query
            OR avis.description LIKE :query
        )
        AND course.IdChauffeur = :Id
    ORDER BY course.DateReservation DESC
    ");

    $req->bindParam(':query', $query);
    $req->bindParam(':Id', $Idchauffeur);
    
    $req->execute();

    $resultats = array();
    while ($rep = $req->fetch(PDO::FETCH_ASSOC)) {
        $resultats[] = $rep;
    }
    var_dump($resultats);

    return $resultats;
}
    
public function GetnewCourse(){
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
            course.IdChauffeur = 13
            AND course.DateReservation > CURRENT_DATE
            ORDER BY course.DateReservation DESC
    ");

    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;

}




    public function RetirerChauffeur($Id){
    $req = $this->Bdd->prepare("UPDATE personne SET IdStatus = 1 WHERE Id =:Id");
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }
    }

    public function Recherche($requete){
        $req = $this->Bdd->prepare("SELECT * FROM personne 
            INNER JOIN typepersonne on personne.IdStatus = typepersonne.Id
            WHERE typepersonne.NomTitre ='Chauffeur' AND
                  (personne.Nom LIKE :rq OR
                   personne.Prenom LIKE :rq OR 
                   personne.Email LIKE :rq OR 
                   personne.NumeroDeTelephone LIKE :rq) ");
        $requete = '%'.$requete.'%';
        $req->bindParam(':rq', $requete);

        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Ajout($Id){
        $req = $this->Bdd->prepare("UPDATE personne SET IdStatus = 2 WHERE Id = :Id");
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }
    }


}

?>