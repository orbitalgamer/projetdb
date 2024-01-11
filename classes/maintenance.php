<?php


require_once 'Bdd.php';


/**
 * création classe vehicule pour crée méthode pour inserer une voiture
 */
class Maitenance
{
    public $Id;
    public $Description;
    public $DateDebut;
    public $DateFin;
    public $Bdd;

    public function __construct()
    {
        $db = new Bdd();
        $this->Bdd = $db->getBdd();
    }

    public function GetId($Id)
    {//pour avoir photo
        $req = $this->Bdd->prepare("SELECT 
            * FROM maintenance
        WHERE IdProbleme = :Id
        "); //recherche tous les historique de problème pour une voiture

        $req->bindParam(':Id', $Id);
        $req->execute();
        $retour = array();
        while ($rep = $req->fetch()) {
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Insert($IdProbleme){
        if(!empty($this->DateDebut) && !empty($this->DateFin) && !empty($this->Description)){
            if($this->DateDebut <= $this->DateFin){
                //verifier pas que ajoute 2 fois là même cause d'un F5
                $req = $this->Bdd->prepare("SELECT Id FROM maintenance WHERE 
                                   DateDebut =:DateDebut AND 
                                   DateFin =:DateFin AND 
                                   Description =:Description AND
                                   IdProbleme =:IdProblem");
                $req->bindParam(':DateDebut', $this->DateDebut);
                $req->bindParam(':DateFin', $this->DateFin);
                $req->bindParam(':Description', $this->Description);
                $req->bindParam(':IdProblem', $IdProbleme);
                $req->execute();

                if(!$req->fetch()) { //si existe pas

                    $req = $this->Bdd->prepare('INSERT INTO maintenance 
                                                    (Description, DateDebut, DateFin, IdProbleme) 
                                                    VALUES (:Description, :DateDebut, :DateFin, :IdProblem) ');

                    $req->bindParam(':DateDebut', $this->DateDebut);
                    $req->bindParam(':DateFin', $this->DateFin);
                    $req->bindParam(':Description', $this->Description);
                    $req->bindParam(':IdProblem', $IdProbleme);

                    if ($req->execute()) {
                        return array("succes" => 1);
                    } else {
                        return array("error" => 1);
                    }
                }
            }
            else{
                return array("error"=>1);
            }
        }
        else{
            return array("error"=>1);
        }
    }


}


?>