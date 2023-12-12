<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi de photo</title>
</head>
<body>

<?php
// Vérifier si le formulaire a été soumis
//phpinfo();

$uploadMaxSize = ini_get('upload_max_filesize');
echo "La taille maximale autorisée pour les fichiers téléchargés est : $uploadMaxSize";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES["photo"])) {
        $uploadDir = "uploads/"; // Répertoire où vous souhaitez enregistrer les photos

        // Vérifier si le répertoire existe, sinon le créer
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Vérifier s'il y a des erreurs lors du téléchargement
        if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
            $uploadFile = $uploadDir . basename($_FILES["photo"]["name"]);

            // Vérifier si le fichier est une image réelle
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if ($check !== false) {
                // Déplacer le fichier téléchargé vers le répertoire d'upload
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

<!-- Formulaire HTML pour télécharger une photo -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="photo">Sélectionner une photo :</label>
    <input type="file" name="photo" id="photo" accept="image/*">
    <br>
    <input type="submit" value="Télécharger la photo">
</form>

</body>
</html>
