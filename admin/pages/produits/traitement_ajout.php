<?php
session_start();

// Inclusion du fichier de fonctions
include '../../../constants/functions.php';

// Vérification des données du formulaire
if(isset($_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['stock'], $_POST['categorie'], $_FILES['image'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $categorie = $_POST['categorie'];
    $image = $_FILES['image'];

    // Vérifier si une image a été téléchargée
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Récupérer le nom temporaire de l'image
        $image_tmp = $_FILES['image']['tmp_name'];
        
        // Définir le chemin de destination de l'image
        $image_destination = 'images/' . $_FILES['image']['name'];
        
        // Déplacer l'image téléchargée vers le répertoire de destination
        if(move_uploaded_file($image_tmp, $image_destination)) {
            // Appel de la fonction d'insertion de produit avec le chemin de l'image
            if(insertProduit($nom, $description, $prix, $stock, $categorie, $image_destination)) {
                // Redirection vers une page de succès si l'insertion est réussie
                header("Location: produits.php?success_ajout=ok");
                exit();
            } else {
                // Redirection vers une page d'erreur si l'insertion échoue
                header("Location: ajoutProduit.php?error_ajout=error");
                exit();
            }
        } else {
            // Redirection vers une page d'erreur si le déplacement de l'image a échoué
            header("Location: ajoutProduit.php?error_ajout=error_upload");
            exit();
        }
    } else {
        // Redirection vers une page d'erreur si aucune image n'a été téléchargée
        header("Location: ajoutProduit.php?error_ajout=no_image");
        exit();
    }
} else {
    // Redirection vers une page d'erreur si des données requises sont manquantes
    header("Location: ajoutProduit.php?error_ajout=missing_data");
    exit();
}
?>
