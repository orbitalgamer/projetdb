<?php

require_once 'Bdd.php';


/**
 * création classe vehicule pour crée méthode pour inserer une voiture
 */
class vehicule
{
public $PlaqueVoiture;
public $Marque;
public $Modele;
public $Couleur;
public $Annee;
public $Carburant;
public $Kilometrage;
public $PlaceDisponible;
public $PMR;
public $Bdd;

public function __construct(){
    $db = new Bdd();
    $this->Bdd=$db->getBdd();
}

public function Insert(){
    if(!empty($this->PlaceDisponible) && !empty($this->Marque) && !empty($this->Modele) && !empty($this->Couleur) && !empty($this->Annee) && !empty($this->Carburant) && !empty($this->Kilometrage) && !empty($this->PlaqueVoiture) && isset($this->PMR)) {
        $req = $this->Bdd->prepare("SELECT PlaqueVoiture FROM vehicule WHERE PlaqueVoiture = :plaque");
        $req->bindParam(':plaque', $this->PlaqueVoiture);
        $req->execute();

        if (!$req->fetch()) {
            $req = $this->Bdd->prepare("
                                    INSERT INTO vehicule (PlaqueVoiture, Marque, Modele, Couleur, Annee, Carburant, Kilometrage, PlaceDisponible, PMR) 
                                    VALUES (:PlaqueVoiture, :Marque, :Modele, :Couleur, :Annee, :Carburant, :Kilometrage, :PlaceDisponible, :PMR)");
            $req->bindParam(':PlaqueVoiture', $this->PlaqueVoiture);
            $req->bindParam(':Marque', $this->Marque);
            $req->bindParam(':Modele', $this->Modele);
            $req->bindParam(':Couleur', $this->Couleur);
            $req->bindParam(':Annee', $this->Annee);
            $req->bindParam(':Carburant', $this->Carburant);
            $req->bindParam(':Kilometrage', $this->Kilometrage);
            $req->bindParam(':PlaceDisponible', $this->PlaceDisponible);
            $req->bindParam(':PMR', $this->PMR);
            if ($req->execute()) {

                return array('succes' => '1');
            } else {
                //var_dump($req->errorInfo());
                return array('error' => 'erreur requete');
            }
        }
        else{
            return array('error' => 'voiture existe deja');
        }
    }


    else {
            return array('error' => 'manque param');
        }

}

public function GetTypeCarburant(){
    $req = $this->Bdd->query("SELECT * FROM typecarburant");
    $sortie = array();
    while($rep = $req->fetch()){
        array_push($sortie, $rep);
    }
    return $sortie;
}

public function GetInfo($plaque){
    $req = $this->Bdd->prepare("SELECT vehicule.*, prix.PrixAuKilometre FROM vehicule
         LEFT JOIN (SELECT t.PlaqueVehicule,  t.PrixAuKilometre FROM tarification t ORDER BY t.Id DESC LIMIT 1) prix 
        ON prix.PlaqueVehicule = vehicule.PlaqueVoiture
         WHERE PlaqueVoiture = :plaque"); //peut simplifier recherche à limit 1 car ainsi prend le le plus élevé pour ce véhicule
    $req->bindParam(':plaque', $plaque);
    $req->execute();
    $rep=$req->fetch();
    return $rep;
}

    public function GetAll(){
        $req = $this->Bdd->query("
    SELECT 
        vehicule.*, 
        typecarburant.Nom as 'NomCarburant',
        prixMax.PrixAuKilometre as 'PrixDernier',
        MAX(IF(NOT probleme.Regle, 1, 0)) as 'problem'
    FROM vehicule
    INNER JOIN typecarburant on typecarburant.Id = vehicule.Carburant
    LEFT JOIN tarification prix on vehicule.PlaqueVoiture = prix.PlaqueVehicule 
    LEFT JOIN (SELECT PrixAuKilometre, PlaqueVehicule FROM tarification WHERE Id IN(
        SELECT MAX(Id) FROM tarification GROUP BY PlaqueVehicule)) prixMax 
        on prixMax.PlaqueVehicule = vehicule.PlaqueVoiture
    LEFT JOIN course on prix.Id = course.IdTarification
    LEFT JOIN probleme on course.Id = probleme.IdCourse
    
    GROUP BY vehicule.PlaqueVoiture
    ORDER BY problem DESC
    
    "); //inner jion pour type carburant car toujours un carburant
        // left join tarificaiton c'est pour avoir tous les prix pour rechercher pour accidnet
        //l'autre left join avec requète imbrique c'est pour avoir le dernier prix
        //lie avec cours sur tous les Id tarification
        // lie sur problème pour avoir tous les problème
        // crée nouveau champ càd que regarder toute les problème et va regarde si réglé ou pas si pas rélgé 1 sinon 0 et prend 1 pour être sur de na pas louper 1 seul pas réglé
        // groupe à la fin
        //requète permet de rechercher le dernier prix pour chauque véhicule
        //esuite lie tout jusque problem
        //group à la fin

        /*
         * LEFT JOIN (SELECT t.Id,t.PlaqueVehicule,  t.PrixAuKilometre FROM tarification t WHERE Id IN
    (SELECT MAX(e.Id) FROM tarification e GROUP BY e.PlaqueVehicule)) prix
        ON prix.PlaqueVehicule = vehicule.PlaqueVoiture
         * */

        $retour = array();
        while($rep=$req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Rechercher($querry){ //pour rechercher peut rechercher selon carburant, plaque, marque, modele, pmr, annee
        $req = $this->Bdd->prepare("
                SELECT 
                    vehicule.*, 
                    typecarburant.Nom as 'NomCarburant',
                    prixMax.PrixAuKilometre as 'PrixDernier',
                    MAX(IF(NOT probleme.Regle, 1, 0)) as 'problem'
                FROM vehicule
                INNER JOIN typecarburant on typecarburant.Id = vehicule.Carburant
                LEFT JOIN tarification prix on vehicule.PlaqueVoiture = prix.PlaqueVehicule 
                LEFT JOIN (SELECT PrixAuKilometre, PlaqueVehicule FROM tarification WHERE Id IN(
                    SELECT MAX(Id) FROM tarification GROUP BY PlaqueVehicule)) prixMax 
                    on prixMax.PlaqueVehicule = vehicule.PlaqueVoiture
                LEFT JOIN course on prix.Id = course.IdTarification
                LEFT JOIN probleme on course.Id = probleme.IdCourse
    
                WHERE typecarburant.Nom LIKE :rq 
                OR PlaqueVoiture LIKE :rq 
                OR Marque LIKE :rq 
                OR Modele LIKE :rq
                OR PMR LIKE :rq
                OR Annee LIKE :rq
                
                GROUP BY vehicule.PlaqueVoiture
                ORDER BY problem DESC");
        $querry = '%'.$querry.'%';
        $req->bindParam(':rq', $querry);
        $req->execute();
        $retour = array();
        while($rep=$req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }


    public function Update(){
        if(!empty($this->PlaceDisponible) && !empty($this->Marque) && !empty($this->Modele) && !empty($this->Couleur) && !empty($this->Annee) && !empty($this->Carburant) && !empty($this->Kilometrage) && !empty($this->PlaqueVoiture) && isset($this->PMR)) {
            $req = $this->Bdd->prepare("SELECT PlaqueVoiture FROM vehicule WHERE PlaqueVoiture = :plaque");
            $req->bindParam(':plaque', $this->PlaqueVoiture);
            $req->execute();

            if ($req->fetch()) {
                $req = $this->Bdd->prepare("
                                    UPDATE vehicule SET 
                                                        PlaqueVoiture =:PlaqueVoiture,
                                                        Marque=:Marque, 
                                                        Modele=:Modele, 
                                                        Couleur =:Couleur, 
                                                        Annee=:Annee, 
                                                        Carburant=:Carburant, 
                                                        Kilometrage =:Kilometrage, 
                                                        PlaceDisponible=:PlaceDisponible, 
                                                        PMR =:PMR 
                                                        WHERE PlaqueVoiture =:PlaqueVoiture");
                $req->bindParam(':PlaqueVoiture', $this->PlaqueVoiture);
                $req->bindParam(':Marque', $this->Marque);
                $req->bindParam(':Modele', $this->Modele);
                $req->bindParam(':Couleur', $this->Couleur);
                $req->bindParam(':Annee', $this->Annee);
                $req->bindParam(':Carburant', $this->Carburant);
                $req->bindParam(':Kilometrage', $this->Kilometrage);
                $req->bindParam(':PlaceDisponible', $this->PlaceDisponible);
                $req->bindParam(':PMR', $this->PMR);
                if ($req->execute()) {

                    return array('succes' => '1');
                } else {
                    //var_dump($req->errorInfo());
                    return array('error' => 'erreur requete');
                }
            }
            else{
                return array('error' => 'voiture existe pas');
            }
        }


        else {
            return array('error' => 'manque param');
        }

    }

    public function GetAllPrix($plaque){
        $req = $this->Bdd->prepare("SELECT * FROM tarification WHERE PlaqueVehicule = :plaque");
        $req->bindParam(':plaque', $plaque);
        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;

    }

    public function NewPrix($prix, $plaque)
    {
        //vérifie si pas rafréchit page et a le même pour réencoder le même

        $allprix = $this->GetAllPrix($plaque);
        $lastprix = end($allprix);

        if ($lastprix['PrixAuKilometre'] != $prix) {

            $req = $this->Bdd->prepare("INSERT INTO tarification (PrixAuKilometre, PlaqueVehicule) VALUES (:prix, :plaque)");
            $req->bindParam(':prix', $prix);
            $req->bindParam(':plaque', $plaque);
            if ($req->execute()) {
                return array("succes" => "1");
            } else {
                return array("error" => "erreur requette");
            }

        }
    }
    public function Delete($plaque){

    $req = $this->Bdd->prepare("DELETE FROM vehicule WHERE PlaqueVoiture = :plaque");
    $req->bindParam(':plaque', $plaque);
    if($req->execute()){
        return array("succes" => "1");
    } else {
        return array("error" => "erreur requette");
    }
    }

}

?>