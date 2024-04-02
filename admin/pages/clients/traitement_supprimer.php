<?php

session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: /MixMart/auth/login.php');
    exit();
}


// Vérification de la présence de l'ID de l'article dans l'URL
if(isset($_GET['id_utilisateur']) && is_numeric($_GET['id_utilisateur'])) {
    $id = $_GET['id_utilisateur'];

    // Inclusion du fichier de connexion PDO
    include '../../../constants/functions.php';
    $connect = connect();

    try {
        // Requête SQL sécurisée pour supprimer l'article
        $sql = "DELETE FROM utilisateur WHERE ID_utilisateur = :id_utilisateur";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Vérification du nombre de lignes affectées
        if($stmt->rowCount() > 0) {
            // Redirection vers la page des articles avec un message de succès
            header("Location: clients.php?success_supp=ok");
            exit();
        } else {
            // Redirection vers la page des articles avec un message d'erreur
            header("Location: clients.php?error_supp=error1");
            exit();
        }
    } catch (PDOException $e) {
        // Affichage de l'erreur en cas d'échec de la requête
        echo "Erreur lors de la suppression du client : " . $e->getMessage();
        exit();
    }
} else {
    // Redirection vers la page des articles si l'ID n'est pas valide ou n'est pas fourni
    header("Location: clients.php?error_supp=error2");
    exit();
}
?>
