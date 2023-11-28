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
private $NomTable = "personne";
private $NomTableType = "typepersonne";

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


}

?>