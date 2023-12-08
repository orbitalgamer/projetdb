<?php
include "bdd.php";
include "localite.php";
$adresse = "rue de houdain 9c blaregnies";
$adresse1 = "rue des martyrs frameries";
// function getLatitude($adresse){

// $adresse_array = explode(" ",$adresse);
// $adresse_return = implode(" +",$adresse_array);
// $json_url = 'https://maps.open-street.com/api/geocoding/?address=';
// $json_url = $json_url . "" . implode("+",$adresse_array) . "+Belgique&sensor=false&key=47773fb81cab254622128272f7b69c59";
// $json = file_get_contents($json_url);
// $data = json_decode($json, TRUE);
// $latitude = $data["results"][0]["geometry"]["location"]["lat"];
// return $latitude;
// }
// function getLongitude($adresse){

//     $adresse_array = explode(" ",$adresse);
//     $adresse_return = implode(" +",$adresse_array);
//     $json_url = 'https://maps.open-street.com/api/geocoding/?address=';
//     $json_url = $json_url . "" . implode("+",$adresse_array) . "+Belgique&sensor=false&key=47773fb81cab254622128272f7b69c59";
    
//     $json = file_get_contents($json_url);
//     $data = json_decode($json, TRUE);
  
//     $latitude = $data["results"][0]["geometry"]["location"]["lng"];
//     return $latitude;
//     }
    



   




// function itineraire($latitudeInit,$longitudeInit,$latitudeFinal,$longitudeFinal){
//     $json_url="https://maps.open-street.com/api/route/?origin={$latitudeInit},{$longitudeInit}&destination={$latitudeFinal},{$longitudeFinal}&mode=driving&key=47773fb81cab254622128272f7b69c59";
//     echo $json_url;
//     $json = file_get_contents($json_url);
//     $data = json_decode($json, TRUE);
//     $distance = $data["total_distance"];
//     $time = $data["total_time"];
     
//     // $array_result = [$distance,$time];

//     return $data;
  
    
 
// }
// $LatInit = getLatitude($adresse);
// $LatFinal =  getLatitude($adresse1);
// $LngInit = getLongitude($adresse);
// $LngFinal = getLongitude($adresse1);
// $ite = itineraire($LatInit,$LngInit,$LatFinal,$LngFinal);
// print_r($ite["polyline"]);   

// ;


// function decodePolyline($encoded) {
//     $length = strlen($encoded);
//     $index = 0;
//     $points = array();

//     $lat = 0;
//     $lng = 0;

//     while ($index < $length) {
//         $shift = 0;
//         $result = 0;

//         do {
//             $b = ord(substr($encoded, $index++, 1)) - 63;
//             $result |= ($b & 0x1F) << $shift;
//             $shift += 5;
//         } while ($b >= 0x20);

//         $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));
//         $lat += $dlat;

//         $shift = 0;
//         $result = 0;

//         do {
//             $b = ord(substr($encoded, $index++, 1)) - 63;
//             $result |= ($b & 0x1F) << $shift;
//             $shift += 5;
//         } while ($b >= 0x20);

//         $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
//         $lng += $dlng;

//         $points[] = array($lat / 1e5, $lng / 1e5);
//     }

//     return $points;
// }

// // Exemple d'utilisation
// $encodedPolyline = "unjf_Bo|gpFCi@oAkU_AqOCuJrQuCbY}Btu@gGb@CfKy@bBKvDa@h@GdQ}AbAKhTuB`C`GrQv`@t@vA~o@xmA`G~K|InPzNpWfa@rv@`HlNh@bAr@~Bx@xEZ~FIfGqDrWqAxJaEpZe@nDmBpNtL~JtGdEzHzFvDjB|_@dM~Al@bDn@lM~AfFf@bM|BdYlGbFhEbBx@vDfBzMrD`D`@nBTpFn@`mBvm@lCvAlAlA|@ZjC|@zHrChBj@t@DzADlB_@dB?x`AzZzWpIjBx@dCjBtAnBzAjCz@dBlA`AjATlAKfAm@z@kA^eAjC_Dd@]|AcA~Aq@t@[pHgDbY}NtFuCbMkGdSqMpOaHpCoAx@[fNsGrHyDlBaAhRwJtImErBeAxMkHxIeExFuBtFoAjIkAtKkAtVqAhQaAjJi@tMi@vHEnCJpCNdNfBtHfA~Fr@lInA|O~BxGbAhQnB`DNnDNvNCjRIbPD|CDjIDpNTtDJrDh@fDt@|CbAbQlI~M|GfBdA~BjApAb@lA^fDx@fCZjBFbEGr@ApBM`Eu@pCs@tCu@dBi@vBs@nI_DtD{AvFiCnG}CfFaDfHkErCaB`a@gVbRoK~DaC~FcDpC}AfK{FdB{@lEyB~GaCdFeAhGe@rI{@tEe@dF]|PyAjJcA`AGlGLhAr@|@lAv@lB\jA\tCXrDI~Eo@zGoE|SsIfb@s@pEYdFOrGIjIf@dJ|@fI~BrLbCfGzCxFLNnIbJnM~Iz}@rh@tAv@pBnAnc@|W`F|C^VvCjBxIrFzIjG`UjTzRzV`DnF~JvP`C`E`@t@|KnT^t@hEzIjO~[`Rrb@tDrI`Vng@bCfF~CtFdMpTvDxG|b@tr@|Rr[xu@hoA|F|IrHfLpJtOnKrPfUp^nFxI~N~UxLpSha@xq@xLvTnG|MbBpDnCzFjXln@fB~DhZfr@r\zv@`@`AvMxZzL|XfOrZnKhT~@xBjBvD|FjKzZdj@`L`RjDbGbHzKzAzB~Rb[rJnMlQ|Uvg@`p@nDfE~ElFzRhS~\r]hD|CvGbGtXxU~b@z[rWpQ`MrIpa@`Y|y@lk@dJlGri@p_@jQ~Lf\dUlTlOtHjF~DpCrIzFrJrGlSbNjh@|]zY|SdCfBfIbGaAlOyApUwGpdAiAhQ}B~\oGz`Au@|KmGhhA[vFK|BeB`VoEhr@_BfXAHi@bIyDlf@{PjsCiGt`A}@pM{Els@MhBMlBoBbZ_BzVWjD_ArOaVdhDcDdg@SxCw@pLwCfc@]|EyEp{@eCt`@c@vH_@rFe@`HmKxcBQpCeBtXq@jGwA~I_C`LcTjw@_EjOcGbTyFhRuRfs@iAdEk@_@i@Cg@Pa@b@Wj@Mz@Az@Fz@Rr@\f@sBfKWbBs@xEaApGe@~CmA`L{Cv_@wBdXuBrWxSbKfCnAxHtEtBzBpM|_@"; // Votre polyline encodée
// $decodedPoints = decodePolyline($encodedPolyline);
// echo "<br>";
// // Afficher les points décodés
// print_r($decodedPoints);




class adresse{

    public $Id;
    public $Numero;
    public $Rue;
    public $Ville;
    public $NomAdresse;
    public $latitude;
    public $longitude; 
    private $Bdd;
    private $NomTable = "adresse";
    
 

    public function __construct($db){  

        $this->Bdd = $db; 
        
    }




    public function creation(){
        $query = "SELECT * FROM $this->NomTable WHERE latitude BETWEEN $this->latitude - 0.00000001 AND $this->latitude + 0.00000001 AND longitude BETWEEN $this->longitude - 0.00000001 AND $this->longitude + 0.00000001";
        $rq = $this->Bdd->prepare($query);
        $rq->execute(); 
        $rep=$rq->fetch(PDO::FETCH_ASSOC);
        print_r($rep);
        /**Le principe est de verifier que les latitudes et longitudes rentrés n'existe pas dans le bdd pour économiser des réquetes APIs */
    
        if($rep==null) {
            $query = "INSERT INTO $this->NomTable (
                Id,
                Numero,
                Rue,
                Ville,
                NomAdresse,
                latitude,
                longitude)
                VALUES
                (NULL,
                :Numero,
                :Rue,
                :Ville,
                :NomAdresse,
                :latitude,
                :longitude)";
                
            $rq = $this->Bdd->prepare($query);
            $rq->bindParam(':Numero',$this->Numero);
            $rq->bindParam(':Rue',$this->Rue);
            $rq->bindParam(':Ville',$this->Ville);
            $rq->bindParam(':NomAdresse',$this->NomAdresse);
            $rq->bindParam(':latitude',$this->latitude);
            $rq->bindParam(':longitude',$this->longitude);
            
        try{
    
            $rq->execute();
            $rep = $rq->fetch(PDO::FETCH_ASSOC);
            
        }
        catch(PDOException $e){
            $e = explode(" ",$e);
            if($e[1]== "SQLSTATE[23000]:"){
                $newLocalite = new localite($this->Bdd);
                $newLocalite->Ville = $this->Ville;
                $newLocalite->creation();
                $rq->execute();
                $rep = $rq->fetch(PDO::FETCH_ASSOC);
                echo json_decode($rep);
            }
            else
            {
                echo "error";
            }
        }
    }
    else
    {
        $array_result = $this->selection();
        return $array_result;
    }


}
public function selection(){
    $query = "SELECT Id,Numero,Rue,Ville,NomAdresse,latitude,longitude FROM $this->NomTable WHERE Rue='$this->Rue'"; 
    $rq = $this->Bdd->prepare($query);
    if($rq->execute()){
      $rep=$rq->fetch(PDO::FETCH_ASSOC);
      echo "la";
      
      return $rep;
   
    }
    else
    {
        echo "pas marché";
    }
    
    }

   
}


?>