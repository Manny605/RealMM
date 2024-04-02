<?php
session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: /MixMart/auth/login.php');
    exit();
}


if (isset($_POST["id_utilisateur"], $_POST['prenom'], $_POST['nom'], $_POST['nom_utilisateur'], $_POST['phone'], $_POST['mdp'])) {

        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $nom_utilisateur = $_POST["nom_utilisateur"];
        $phone = $_POST["phone"];
        $mdp = $_POST["mdp"];

    include '../../../constants/functions.php';
    $connect = connect();

    $sql = "UPDATE utilisateur SET Prenom = :prenom, Nom = :nom, Nom_utilisateur = :nom_utilisateur, Phone = :phone, MotDePasse = :mdp WHERE ID_utilisateur = :id_utilisateur";
    $stmt = $connect->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':prenom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':nom_utilisateur', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':mdp', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':id_utilisateur', $id, PDO::PARAM_INT);
    
    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if($stmt->rowCount() > 0) {
        header("Location: clients.php?success_modif=ok");
        exit();
    } else {
        header("Location: clients.php?error_modif=error1");
        exit();
    }
} else {
    // Handle the case where form data is missing
    // You may want to redirect the user to a proper error page
    header("Location: clients.php?error_modif=error2");
    exit();
}
?>
