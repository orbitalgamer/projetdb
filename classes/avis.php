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


}

?>