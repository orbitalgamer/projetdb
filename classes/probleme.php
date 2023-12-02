<?php

require_once 'Bdd.php';


/**
 * création classe vehicule pour crée méthode pour inserer une voiture
 */
class probleme
{
    public $Id;
    public $Description;
    public $Regle;
    public $IdCourse;
    public $IdAdresse;
    public $IdTypeProbleme;
    public $Bdd;

    public function __construct(){
        $db = new Bdd();
        $this->Bdd=$db->getBdd();
    }

    public function GetAll(){
        $req = $this->Bdd->query("SELECT 
            probleme.*, 
            vehicule.PlaqueVoiture as 'Plaque',
            typeprobleme.Nom as 'NomProbleme',
            IF(maintenance.Id is not null, 'Oui', 'Non') as 'MaitenancePrevu'
             FROM probleme
        INNER JOIN typeprobleme on probleme.IdTypeProbleme = typeprobleme.Id
        INNER JOIN course on probleme.IdCourse = course.Id
        INNER JOIN tarification on course.IdTarification = tarification.Id
        INNER JOIN vehicule on tarification.PlaqueVehicule = vehicule.PlaqueVoiture
        LEFT JOIN maintenance on probleme.Id = maintenance.IdProbleme
        ORDER BY probleme.Regle, probleme.Id
        "); //va prend tous les problèmes, va rechecher pour quel véhicule et repredn plaque, type, si peut roler si mainteance prévu pour ça regarde si occurence et si reglé

        $retour = array();
        while($rep=$req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }
    public function Recherche($requete){
        $req = $this->Bdd->prepare("SELECT 
            probleme.*, 
            vehicule.PlaqueVoiture as 'Plaque',
            typeprobleme.Nom as 'NomProbleme',
            IF(maintenance.Id is not null, 'Oui', 'Non') as 'MaitenancePrevu'
             FROM probleme
        INNER JOIN typeprobleme on probleme.IdTypeProbleme = typeprobleme.Id
        INNER JOIN course on probleme.IdCourse = course.Id
        INNER JOIN tarification on course.IdTarification = tarification.Id
        INNER JOIN vehicule on tarification.PlaqueVehicule = vehicule.PlaqueVoiture
        INNER JOIN personne chauffeur on course.IdChauffeur = chauffeur.Id
        LEFT JOIN maintenance on probleme.Id = maintenance.IdProbleme
        
        WHERE 
            vehicule.PlaqueVoiture LIKE :rq OR 
            chauffeur.Nom LIKE :rq OR 
            chauffeur.Prenom LIKE :rq OR
            typeprobleme.Nom LIKE :rq
             
        ORDER BY probleme.Regle, probleme.Id

        "); //avoir même chose mais que peut faire recherche dedans

        $requete = '%'.$requete.'%';

        $req->bindParam(':rq', $requete);
        $req->execute();

        $retour = array();
        while($rep=$req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function GetAccident($plaque){
        $req = $this->Bdd->prepare("SELECT 
            probleme.*,
            typeprobleme.Nom as 'NomProbleme',
            IF(maintenance.Id is not null, '1', '0') as 'MaitenancePrevu'
             FROM probleme
        INNER JOIN typeprobleme on probleme.IdTypeProbleme = typeprobleme.Id
        INNER JOIN course on probleme.IdCourse = course.Id
        INNER JOIN tarification on course.IdTarification = tarification.Id
        INNER JOIN vehicule on tarification.PlaqueVehicule = vehicule.PlaqueVoiture
        LEFT JOIN maintenance on probleme.Id = maintenance.IdProbleme
        WHERE vehicule.PlaqueVoiture = :plaque
        "); //recherche tous les historique de problème pour une voiture

        $req->bindParam(':plaque', $plaque);
        $req->execute();

        $retour = array();
        while($rep=$req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }
    public function GetAccidentId($Id){
        $req = $this->Bdd->prepare("SELECT 
            probleme.*,
            vehicule.PlaqueVoiture as 'plaque',
            vehicule.Modele as 'model',
            vehicule.Marque as 'marque',
            vehicule.Annee as 'annee',
            vehicule.Kilometrage as 'kilometrage',
            typeprobleme.Nom as 'NomProbleme',
            personne.Nom as 'nomChauffeur',
            personne.Prenom as 'prenomChauffeur',
            IF(maintenance.Id is not null, '1', '0') as 'MaitenancePrevu'
             FROM probleme
        INNER JOIN typeprobleme on probleme.IdTypeProbleme = typeprobleme.Id
        INNER JOIN course on probleme.IdCourse = course.Id
        INNER JOIN personne on course.IdChauffeur = personne.Id
        INNER JOIN tarification on course.IdTarification = tarification.Id
        INNER JOIN vehicule on tarification.PlaqueVehicule = vehicule.PlaqueVoiture
        LEFT JOIN maintenance on probleme.Id = maintenance.IdProbleme
        WHERE probleme.Id = :Id
        "); //recherche tous les historique de problème pour une voiture

        $req->bindParam(':Id', $Id);
        $req->execute();
        $rep = $req->fetch();
        return $rep;
    }
    public function GetPhoto($Id){//pour avoir photo
        $req = $this->Bdd->prepare("SELECT 
            * FROM photoprobleme
        WHERE IdProbleme = :Id
        "); //recherche tous les historique de problème pour une voiture

        $req->bindParam(':Id', $Id);
        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function GetMaintenance($Id){//pour avoir photo
        $req = $this->Bdd->prepare("SELECT 
            * FROM maintenance
        WHERE IdProbleme = :Id
        "); //recherche tous les historique de problème pour une voiture

        $req->bindParam(':Id', $Id);
        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Regler($Id){
        $rep= $this->Bdd->prepare("UPDATE probleme SET Regle = 1 WHERE Id =:Id");
        $rep->bindParam(':Id', $Id);
        if($rep->execute()){
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }

    }




}

?>