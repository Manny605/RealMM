<?php
session_start();

include_once("../constants/functions.php"); // Inclure le fichier de fonctions

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: ../auth/login.php');
    exit(); // Arrêter l'exécution du script
}

// Vérifier si le formulaire a été soumis et si le bouton "add_to_cart" a été cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Récupérer l'ID du produit à partir du formulaire
    $product_id = $_POST['product_id'];

    $categorie_id = $_POST['categorie_id'];

    $quantite = $_POST['quantite'];

    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['ID_utilisateur'];

    // Appeler la fonction pour ajouter le produit au panier
    if (insertDansPanier($user_id, $product_id, $quantite)) {
        header("Location: tous_articles_categorie.php?idc=$categorie_id&add=ok");
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
        header("Location: tous_articles_categorie.php?idc=$categorie_id&alreadyAdd=ok");
        exit(); // Arrêter l'exécution du script après la redirection
    }
} else {
    // Redirection vers la page d'accueil si le formulaire n'a pas été soumis correctement
    header("Location: ../index.php");
    exit(); // Arrêter l'exécution du script après la redirection
}
?>
