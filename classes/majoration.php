<?php


require_once 'Bdd.php';


/**
 * création classe vehicule pour crée méthode pour inserer une voiture
 */
class Majoration
{
    public $Id;
    public $Nom;
    public $Coefficient;

    public $Bdd;

    public function __construct()
    {
        $db = new Bdd();
        $this->Bdd = $db->getBdd();
    }

    public function Insert(){
        if(!empty($this->Nom) && !empty($this->Coefficient)){

            $req = $this->Bdd->prepare("SELECT * FROM typemajoration WHERE Nom=:Nom");
            $req->bindParam(':Nom', $this->Nom);
            $req->execute();

            if(empty($req->fetch())){

                $req = $this->Bdd->prepare("INSERT INTO typemajoration (Nom, Coefficient) VALUES (:Nom, :Coef)");
                $req->bindParam(':Nom', $this->Nom);
                $req->bindParam(':Coef', $this->Coefficient);
                if($req->execute()){
                    return array("succes"=>1);
                }
                else{
                    return array("error"=>"erreur sql");
                }
            }
        }
        else{
            return array("error"=>"param manquant");
        }
    }

    public function Get(){
        $req = $this->Bdd->query("SELECT * FROM typemajoration ORDER BY  ID ASC");
        $req->execute();

        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Delete($Id){
        $req = $this->Bdd->prepare("DELETE FROM typemajoration WHERE Id=:Id");
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }


    }

    public function Update($Id){
        if(!empty($this->Nom) && !empty($this->Coefficient)){
            $req = $this->Bdd->prepare("SELECT * FROM typemajoration WHERE Id = :Id");
            $req->bindParam(':Id', $this->Id);
            $req->execute();

            if($req){
                $req = $this->Bdd->prepare("UPDATE typemajoration SET Nom=:Nom, Coefficient =:Coef WHERE Id =:Id");
                $req->bindParam(':Nom', $this->Nom);
                $req->bindParam(':Coef', $this->Coefficient);
                $req->bindParam(':Id', $Id);
                if($req->execute()){
                    return array("succes"=>1);
                }
                else{
                    return array("error"=>1);
                }
            }
        }
        else{
            return array("error"=>1);
        }
    }

}


?>