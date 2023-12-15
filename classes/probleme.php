<?php

require_once 'Bdd.php';


/**
 * création classe vehicule pour crée méthode pour inserer une voiture
 */
class probleme
{
    public $Id;
    public $Description;

    public $Rouler;
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

    public function GetAllType(){
        $req = $this->Bdd->query("SELECT * FROM typeprobleme");
        $retour = array();
        while($rep=$req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Insert(){
        if(!empty($this->IdAdresse) && !empty($this->IdTypeProbleme) && !empty($this->Description) && !empty($this->IdCourse)){

            $req = $this->Bdd->prepare("SELECT Id FROM probleme WHERE 
                            Rouler=:Rouler AND 
                            IdTypeProbleme =:IdTypeProbleme AND 
                            IdCourse =:IdCourse AND 
                            IdAdresse =:IdAdresse AND
                            Description =:Desc");
            $req->bindParam(':Rouler', $this->Rouler);
            $req->bindParam(':IdTypeProbleme', $this->IdTypeProbleme);
            $req->bindParam(':IdAdresse', $this->IdAdresse);
            $req->bindParam(':IdCourse', $this->IdCourse);
            $req->bindParam(':Desc', $this->Description);


            $req->execute();

            if(empty($req->fetch())){

                $req = $this->Bdd->prepare("INSERT INTO probleme (Description, Regle, Rouler, IdCourse, IdAdresse, IdTypeProbleme) 
                                                                VALUES (:Desc, 0, :Rouler,:IdCourse, :IdAdresse, :IdTypePrboleme)");
                $req->bindParam(':Rouler', $this->Rouler);
                $req->bindParam(':IdTypePrboleme', $this->IdTypeProbleme);
                $req->bindParam(':IdAdresse', $this->IdAdresse);
                $req->bindParam(':IdCourse', $this->IdCourse);
                $req->bindParam(':Desc', $this->Description);

                if($req->execute()){
                    $req = $this->Bdd->prepare("SELECT Id FROM probleme WHERE 
                            Rouler=:Rouler AND 
                            IdTypeProbleme =:IdTypeProbleme AND 
                            IdCourse =:IdCourse AND 
                            IdAdresse =:IdAdresse AND
                            Description =:Desc");
                    $req->bindParam(':Rouler', $this->Rouler);
                    $req->bindParam(':IdTypeProbleme', $this->IdTypeProbleme);
                    $req->bindParam(':IdAdresse', $this->IdAdresse);
                    $req->bindParam(':IdCourse', $this->IdCourse);
                    $req->bindParam(':Desc', $this->Description);


                    $req->execute();
                    return $req->fetch()[0];
                }
            }

        }
        else{
            return array("error"=>1);
        }
    }

    public function GetId($Id){
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
        LEFT JOIN maintenance on probleme.Id = maintenance.IdProbleme
        WHERE probleme.Id = :Id
        "); //va prend tous les problèmes, va rechecher pour quel véhicule et repredn plaque, type, si peut roler si mainteance prévu pour ça regarde si occurence et si reglé

        $req->bindParam(':Id', $Id);

        $req->execute();

        return $req->fetch();
    }

    public function InsertPhoto($url, $IdProblem){
        if(!empty($this->GetId($IdProblem))){
            $req = $this->Bdd->prepare("INSERT INTO photoprobleme (CheminDAcces, IdProbleme) VALUES (:url, :Id)");
            $req->bindParam(':url', $url);
            $req->bindParam(':Id', $IdProblem);

            if($req->execute()){
                return array("succes"=>1);
            }
            return array("error"=>1);
        }
    }

    public function Update($Id){
        if(!empty($this->IdAdresse) && !empty($this->IdTypeProbleme) && !empty($this->Description) && !empty($this->IdCourse)){

                $req = $this->Bdd->prepare("UPDATE probleme SET Description=:Desc, Rouler =:Rouler, IdAdresse=:IdAdresse, IdTypeProbleme=:IdTypePrboleme WHERE Id=:Id");
                $req->bindParam(':Rouler', $this->Rouler);
                $req->bindParam(':IdTypePrboleme', $this->IdTypeProbleme);
                $req->bindParam(':IdAdresse', $this->IdAdresse);
                $req->bindParam(':Desc', $this->Description);
                $req->bindParam(':Id', $Id);

                if($req->execute()){
                   return array("succes"=>1);
                }


        }
        else{
            return array("error"=>1);
        }
    }

}

?>