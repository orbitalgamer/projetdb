<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';



$chauffeur = new chauffeur();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi de photo</title>
</head>
<body>

<?php


$uploadMaxSize = ini_get('upload_max_filesize');
echo "La taille maximale autorisée pour les fichiers téléchargés est : $uploadMaxSize";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
    if (isset($_FILES["photo"])) {
        $uploadDir = "uploads/"; 

        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

       
        if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
            $uploadFile = $uploadDir . basename($_FILES["photo"]["name"]);

            
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if ($check !== false) {
               
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadFile)) {
                    echo "La photo a été téléchargée avec succès.";
                } else {
                    echo "Erreur lors du déplacement du fichier.";
                }
            } else {
                echo "Le fichier n'est pas une image valide.";
            }
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucune photo n'a été téléchargée.";
    }
}
?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="photo">Sélectionner une photo :</label>
    <input type="file" name="photo" id="photo" accept="image/*">
    <br>
    <input type="submit" value="Télécharger la photo">
</form>

</body>
</html>
