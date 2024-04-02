<?php

session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['ID_utilisateur'])) {
    header("Location: ../../../auth/login.php");
    exit();
}

// Inclure le fichier de fonctions contenant la fonction d'insertion
include '../../../constants/functions.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si toutes les données requises sont présentes
    if (isset($_POST["nom_categorie"]) && isset($_FILES["image"])) {
        // Récupère les données du formulaire
        $nom_categorie = $_POST["nom_categorie"];
        $image_path = ""; // Chemin de l'image par défaut
        
        // Vérifie si une image a été téléchargée avec succès
        if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            // Récupère le nom temporaire du fichier
            $tmp_name = $_FILES["image"]["tmp_name"];
            // Génère un nom de fichier unique pour éviter les conflits
            $image_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
            // Déplace le fichier téléchargé vers le répertoire de destination
            $destination = "images/" . $image_name;
            if (move_uploaded_file($tmp_name, $destination)) {
                // Le fichier a été téléchargé avec succès, enregistre le chemin de l'image
                $image_path = $destination;
            } else {
                // Erreur lors du téléchargement de l'image, redirige avec un message d'erreur
                header("Location: categories.php?error_ajout=upload_error");
                exit();
            }
        } else {
            // Erreur lors du téléchargement de l'image, redirige avec un message d'erreur
            header("Location: categories.php?error_ajout=upload_error");
            exit();
        }
        
        // Insérer la catégorie dans la base de données en utilisant la fonction insertCategorie
        insertCategorie($nom_categorie, $image_path);
        
        // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
        header("Location: categories.php?success_ajout=ok");
        exit();

    } else {
        // Rediriger vers une page d'erreur si des données sont manquantes
        header("Location: categories.php?error_ajout=missing_data");
        exit();
    }
    
} else {
    // Rediriger vers une page d'erreur si la requête n'est pas de type POST
    header("Location: categories.php?error_ajout=invalid_request");
    exit();
}

?>
