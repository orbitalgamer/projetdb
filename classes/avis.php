<?php

require_once 'Bdd.php';


/**
 * création classe chauffeur
 */
class avis
{
    public $Id;
    public $Description;

    public $Note;
    public $IdCourse;
    public $Bdd;


    public function __construct(){
        $db = new Bdd();
        $this->Bdd=$db->getBdd();
    }

    public function GetId($Id){ //récupérer les avis pour une course
        $req = $this->Bdd->prepare("SELECT * FROM avis WHERE IdCourse = :Id");
        $req->bindParam(':Id', $Id);
        $req->execute();
        return $req->fetch();
    }

    public function GetAll(){
        $req = $this->Bdd->query("SELECT avis.*,
                                                chauffeur.Nom as 'NomChauffeur',
                                                chauffeur.Prenom as 'PrenomChauffeur',
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        INNER JOIN personne chauffeur on chauffeur.Id = course.IdChauffeur
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        ORDER BY avis.Note ASC, avis.Id DESC");
        $retour = array();
        while($rep= $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }
    public function GetAllChauffeur($Id){
        $req = $this->Bdd->prepare("SELECT avis.*,
                                                course.DateReservation,
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        WHERE course.IdChauffeur = :Id");
        $req->bindParam(':Id', $Id);
        $req->execute();
        $retour = array();
        while($rep= $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Requette($requette){
        $req = $this->Bdd->prepare("SELECT avis.*,
                                                chauffeur.Nom as 'NomChauffeur',
                                                chauffeur.Prenom as 'PrenomChauffeur',
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        INNER JOIN personne chauffeur on chauffeur.Id = course.IdChauffeur
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        WHERE chauffeur.Nom LIKE :rq OR
                                              chauffeur.Prenom LIKE :rq OR 
                                              client.Nom LIKE :rq OR 
                                              client.Prenom LIKE :rq OR
                                              tarification.PlaqueVehicule LIKE :rq OR
                                              avis.Note LIKE :rq
                                        ORDER BY avis.Note ASC, avis.Id DESC");
        $requette = '%'.$requette.'%';
        $req->bindParam(':rq', $requette);
        $req->execute();
        $retour = array();
        while($rep= $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function RequetteChauffeur($requette, $Id){
        $req = $this->Bdd->prepare("SELECT avis.*,
                                                course.DateReservation,
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        WHERE (client.Nom LIKE :rq OR 
                                              client.Prenom LIKE :rq OR
                                              tarification.PlaqueVehicule LIKE :rq OR
                                              avis.Note LIKE :rq) AND course.IdChauffeur =:Id");
        $requette = '%'.$requette.'%';
        $req->bindParam(':rq', $requette);
        $req->bindParam('Id', $Id);
        $req->execute();
        $retour = array();
        while($rep= $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function RequetteNote($min, $max){
        $req = $this->Bdd->prepare("SELECT avis.*,
                                                chauffeur.Nom as 'NomChauffeur',
                                                chauffeur.Prenom as 'PrenomChauffeur',
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        INNER JOIN personne chauffeur on chauffeur.Id = course.IdChauffeur
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        WHERE avis.Note between :min AND :max
                                        ORDER BY avis.Note ASC, avis.Id DESC");

        $req->bindParam(':min', $min);
        $req->bindParam(':max', $max);
        $req->execute();
        $retour = array();
        while($rep= $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function RequetteNoteChauffeur($min, $max, $Id){
        $req = $this->Bdd->prepare("SELECT avis.*,
                                                course.DateReservation,
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        WHERE (avis.Note between :min AND :max) AND IdChauffeur =:Id");

        $req->bindParam(':min', $min);
        $req->bindParam(':max', $max);
        $req->bindParam(':Id', $Id);
        $req->execute();
        $retour = array();
        while($rep= $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Get($Id){
        $req = $this->Bdd->prepare("SELECT avis.*,
                                                chauffeur.Nom as 'NomChauffeur',
                                                chauffeur.Prenom as 'PrenomChauffeur',
                                                client.Nom as 'NomClient',
                                                client.Prenom as 'PrenomClient',
                                                tarification.PlaqueVehicule as 'plaque',
                                                course.Id as 'IdCourse'
                        
                                        FROM avis
                                        INNER JOIN course on avis.IdCourse = course.Id
                                        INNER JOIN personne client on course.IdClient = client.Id
                                        INNER JOIN personne chauffeur on chauffeur.Id = course.IdChauffeur
                                        INNER JOIN tarification on course.IdTarification = tarification.Id
                                        WHERE avis.Id = :Id");
        $req->bindParam(':Id', $Id);
        $req->execute();
        return $req->fetch();

    }

}

?>