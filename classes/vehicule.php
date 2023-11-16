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
    if(!empty($this->PlaceDisponible) && !empty($this->Marque) && !empty($this->Modele) && !empty($this->Couleur) && !empty($this->Annee) && !empty($this->Carburant) && !empty($this->Kilometrage) && !empty($this->PlaqueVoiture) && !empty($this->PMR)){
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

        if($req->execute()){
            return array('succes'=>'1');
        }
        else{
            return array('error'=>'erreur requete');
        }
    }
    else{
        return array('error' => 'manque param');
    }
}


}

?>