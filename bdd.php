
<?php 

try{
    $base = new PDO('mysql:host=localhost;dbname=taxeasy','root','');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Execption $e){
        die('Erreur : '.$e->getMessage());


    }
?>
    


