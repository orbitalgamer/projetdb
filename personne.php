
<?php 

class Personne  {
    public $Id;
    public $Nom;
    public $Prenom;
    public $Email;
    public $Mdp;
    public $NumTel;
    public $IdStatus;

   private $Bdd;
   private $NomTable = "personne";
   private $NomTableType = "typepersonne";
   public function __construct($db){
    $this->Bdd=$db;

   }

   public function creation(){
    $query = "INSERT INTO $this->NomTable (Id,Nom,Prenom,Email,Mdp,NumeroDeTelephone) VALUES (NULL,'$this->Nom', '$this->Prenom','$this->Email','$this->Mdp','$this->NumTel')";
    $rq = $this->Bdd->prepare($query);
    //supprimer les chose pas voule comme des balises html
    $this->Email = strtolower($this->Email);
    $this->Mdp = password_hash($this->Mdp,PASSWORD_DEFAULT);
    if($rq->execute()){
        echo "marché";
    }   
    else
    {
        echo "pas marché";
    }
   }

   public function suppression(){
       $query = "DELETE FROM $this->NomTable WHERE Nom='$this->Nom'";
       $rq = $this->Bdd->prepare($query);

       if($rq->execute()){
        echo"Suppr Marché";
       }
       else{
        echo "SUppr pas marché";
       }
   }
   public function modification(){
    $query = "SELECT Nom,Prenom,Email,Mdp,NumeroDeTelephone FROM $this->NomTable WHERE Id='$this->Id'"; 
    $rq = $this->Bdd->prepare($query);

    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    
    $query =  "UPDATE $this->NomTable SET Nom='$this->Nom',Prenom='$this->Prenom',Email='$this->Email',Mdp='$this->Mdp',NumeroDeTelephone='$this->NumTel' WHERE Id='$this->Id'";
    $rq =$this->Bdd->prepare($query);
    if(!isset($this->Nom)){
        $this->Nom=$rep['Nom'];
    };
    if(!isset($this->Prenom)){
        $this->Prenom=$rep['Prenom'];
    };
    if(!isset($this->Email)){
        $this->Email=$rep['Email'];
    };
    if(!isset($this->Mdp)){
        $this->Mdp=$rep['Mdp'];
    };
    if(!isset($this->NumTel)){
        $this->NumTel=$rep['NumeroDeTelephone'];
    };
    $rq->execute();
    echo json_encode($rep);
   }
   public function selection(){
    $query = "SELECT Nom,Prenom,Email,Mdp,NumeroDeTelephone,IdStatus FROM $this->NomTable WHERE Id='$this->Id'"; 
    $rq = $this->Bdd->prepare($query);
    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    echo json_encode($rep);


   } 
}




?>