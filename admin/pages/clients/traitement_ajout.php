<?php

session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: /MixMart/auth/login.php');
    exit();
}


// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['ID_utilisateur'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../../../auth/login.php");
    exit();
}

include '../../../constants/functions.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_utilisateur"], $_POST['prenom'], $_POST['nom'], $_POST['nom_utilisateur'], $_POST['phone'], $_POST['mdp'])) {
        // Récupère les données du formulaire
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $nom_utilisateur = $_POST["nom_utilisateur"];
        $phone = $_POST["phone"];
        $mdp = $_POST["mdp"];
        
        register($prenom, $nom, $nom_utilisateur, $phone, $mdp);
        
        // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
        header("Location: clients.php?success_ajout=ok");
        exit();

    } else {
        // Rediriger vers une page d'erreur si des données sont manquantes
        header("Location: clients.php?error_ajout=missing_data");
        exit();
    }
    
} else {
    // Rediriger vers une page d'erreur si la requête n'est pas de type POST
    header("Location: clients.php?error_ajout=invalid_request");
    exit();
}

?>
