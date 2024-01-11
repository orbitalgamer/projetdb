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
    SELECT personne.*, COUNT(course.IdChauffeur) as 'CourseFaite'   
    FROM  personne
    LEFT JOIN course on course.IdChauffeur = personne.Id 
     WHERE IdStatus = (SELECT Id FROM typepersonne WHERE NomTitre='Chauffeur')
    GROUP BY personne.Id
    ");
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;
    }

    /*
     * @return tout les chauffeur autonome + le Dernier Id tarrification de la voiture en question
     */
    public function GetAllAutonome(){
        $req = $this->Bdd->query("
    SELECT DISTINCT personne.*,  prixMax.Id as 'IdTarification'
    FROM  personne
    INNER JOIN lienautonome on personne.Id = lienautonome.IdChauffeur
    INNER JOIN (SELECT MAX(Id) as 'Id', PlaqueVehicule FROM tarification GROUP BY PlaqueVehicule) prixMax on prixmax.PlaqueVehicule = lienautonome.PlaqueVehicule
     WHERE IdStatus = (SELECT Id FROM typepersonne WHERE NomTitre='Autonome') AND personne.Prenom!='Supprimer'
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
    JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
    WHERE
        course.IdChauffeur = :Id
        
        AND (
            SELECT MAX(liencourseetat.IdEtat)
            FROM liencourseetat
            WHERE IdCourse = course.Id
        ) = 7;

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
            tarification.PlaqueVehicule,
            CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
            CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin
        FROM
            course
        JOIN personne ON personne.Id = course.IdClient
        JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
        JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
        JOIN tarification on course.IdTarification = tarification.Id
        JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
        WHERE
            course.IdChauffeur = :Id
            
            AND (
                SELECT MAX(liencourseetat.IdEtat)
                FROM liencourseetat
                WHERE IdCourse = course.Id
            ) = 2;
            
    ");



    $req->bindParam(':Id', $Id);
    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;

}
public function Getcourseencours($Id){
    $req = $this->Bdd->prepare("
        SELECT DISTINCT
            course.*,
            personne.Nom,
            personne.Prenom,
            tarification.PlaqueVehicule,
            CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
            CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin
        FROM
            course
        JOIN personne ON personne.Id = course.IdClient
        JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
        JOIN tarification on course.IdTarification = tarification.Id
        JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
        JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
        
        
        
        WHERE
            course.IdChauffeur = :Id
            
            AND (
                SELECT MAX(liencourseetat.IdEtat)
                FROM liencourseetat
                WHERE IdCourse = course.Id
            ) = 4;
            
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
        

    $req = $this->Bdd->prepare("SELECT probleme.Id as 'Id', Regle, Rouler, typeprobleme.Nom as 'NomProblem', tarification.PlaqueVehicule as 'Plaque' FROM probleme 
    INNER JOIN typeprobleme on probleme.IdTypeProbleme = typeprobleme.Id
    INNER JOIN course on probleme.IdCourse = course.Id
    INNER JOIN tarification on course.IdTarification = tarification.Id
    WHERE course.IdChauffeur = :Id
    ");
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
       SELECT course.Id as 'Id', Regle, Rouler, typeprobleme.Nom as 'NomProblem', tarification.PlaqueVehicule as 'Plaque' FROM probleme 
    INNER JOIN typeprobleme on probleme.IdTypeProbleme = typeprobleme.Id
    INNER JOIN course on probleme.IdCourse = course.Id
    INNER JOIN tarification on course.IdTarification = tarification.Id
    WHERE course.IdChauffeur = :Id AND
        (tarification.PlaqueVehicule LIKE :rq OR
         typeprobleme.Nom LIKE :rq)
    ");
    $query = "%".$query.'%';

    $req->bindParam(':rq', $query);
    $req->bindParam(':Id', $Idchauffeur);
    
    $req->execute();

    $resultats = array();
    while ($rep = $req->fetch(PDO::FETCH_ASSOC)) {
        $resultats[] = $rep;
    }
    

    return $resultats;
}

    public function RechercherAcceptation($query){

        $query = '%'.$query.'%';

        $req = $this->Bdd->prepare("
SELECT course.Id as 'Id', tarification.PlaqueVehicule, course.DateReservation,
       personne.Prenom, personne.Nom,
       CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
         CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin
       FROM course 
    INNER JOIN personne on course.IdClient = personne.Id
    INNER JOIN tarification on course.IdTarification = tarification.Id
    INNER JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
    INNER JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
    WHERE 
        (tarification.PlaqueVehicule LIKE :rq OR
         personne.Nom LIKE :rq OR 
         personne.Prenom LIKE :rq) AND IdChauffeur =(SELECT personne.Id FROM personne JOIN typepersonne WHERE personne.Nom='Attente' AND typepersonne.NomTitre='Attente')
    ");
        $query = "%".$query.'%';

        $req->bindParam(':rq', $query);

        $req->execute();

        $resultats = array();
        while ($rep = $req->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $rep;
        }


        return $resultats;
    }

public function Rechercherfutur($Idchauffeur, $query){
    
    $query = '%'.$query.'%';

    $req = $this->Bdd->prepare("
        SELECT DISTINCT 
        course.*,
        personne.Nom,
        personne.Prenom,
        tarification.PlaqueVehicule,
        CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
        CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin
            
        FROM course
        LEFT JOIN personne ON personne.Id = course.IdClient
        LEFT JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
        LEFT JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
        LEFT JOIN avis ON avis.IdCourse = course.Id
        join tarification on course.IdTarification = tarification.Id
        JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
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
        AND (
            SELECT MAX(liencourseetat.Date)
            FROM liencourseetat
            WHERE IdCourse = course.Id
        ) = liencourseetat.Date
        AND liencourseetat.IdEtat = 2;
        
        
    ORDER BY course.DateReservation DESC
    ");
    $query = "%".$query.'%';

    $req->bindParam(':query', $query);
    $req->bindParam(':Id', $Idchauffeur);
    
    $req->execute();

    $resultats = array();
    while ($rep = $req->fetch(PDO::FETCH_ASSOC)) {
        $resultats[] = $rep;
    }
    

    return $resultats;
}
    
public function GetnewCourse(){
    $req = $this->Bdd->prepare("
        SELECT DISTINCT
            course.*,
            personne.Nom,
            personne.Prenom,
            tarification.PlaqueVehicule,
            CONCAT(adresse_depart.vile, ', ', adresse_depart.rue, ' ', adresse_depart.Numero) AS adresse_depart,
            CONCAT(adresse_fin.vile, ', ', adresse_fin.rue, ' ', adresse_fin.Numero) AS adresse_fin
        FROM
            course
        JOIN personne ON personne.Id = course.IdClient
        JOIN tarification on course.IdTarification = tarification.Id
        JOIN adresse AS adresse_depart ON adresse_depart.Id = course.IdAdresseDepart
        JOIN adresse AS adresse_fin ON adresse_fin.Id = course.IdAdresseFin
        WHERE
            course.IdChauffeur = (SELECT personne.Id FROM personne JOIN typepersonne WHERE personne.Nom='Attente' AND typepersonne.NomTitre='Attente')
            AND course.DateReservation > CURRENT_DATE
            ORDER BY course.DateReservation DESC
    ");

    $req->execute();
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    return $resultats;

}




    public function RetirerChauffeur($Id){
    $req = $this->Bdd->prepare("UPDATE personne SET IdStatus = (SELECT  Id FROM typepersonne WHERE NomTitre ='Client') WHERE Id =:Id");
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }
    }



    public function Recherche($requete){
        $req = $this->Bdd->prepare("SELECT personne.*, COUNT(course.IdChauffeur) as 'CourseFaite' FROM personne 
                                            INNER JOIN typepersonne on personne.IdStatus = typepersonne.Id
                                            LEFT JOIN course on course.IdChauffeur = personne.Id
                                            WHERE typepersonne.NomTitre ='Chauffeur' AND
                                                  (personne.Nom LIKE :rq OR
                                                   personne.Prenom LIKE :rq OR 
                                                   personne.Email LIKE :rq OR 
                                                   personne.NumeroDeTelephone LIKE :rq)
                                            GROUP BY personne.Id
                                            
                                            ");
        $requete = '%'.$requete.'%';
        $req->bindParam(':rq', $requete);

        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function GetIdChauffeurAutonome($requete){
        $req = $this->Bdd->prepare("SELECT personne.Id FROM personne 
            INNER JOIN typepersonne on personne.IdStatus = typepersonne.Id
            WHERE typepersonne.NomTitre ='Autonome' AND personne.Prenom LIKE :rq");
        $requete = '%'.$requete.'%';
        $req->bindParam(':rq', $requete);
        $req->execute();
        return $req->fetch();
    }



    public function Ajout($Id){
        $req = $this->Bdd->prepare("UPDATE personne SET IdStatus = (SELECT  Id FROM typepersonne WHERE NomTitre ='Chauffeur') WHERE Id = :Id");
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }
    }

    public function GetId($Id){
        $req = $this->Bdd->prepare("SELECT * FROM personne 
                                            INNER JOIN typepersonne on personne.IdStatus = typepersonne.Id
                                            WHERE typepersonne.NomTitre='Chauffeur' AND personne.Id =:Id");
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            return $req->fetch();
        }
    }

}

?>