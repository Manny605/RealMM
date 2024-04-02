<?php

session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: /MixMart/auth/login.php');
    exit();
}

require_once '../../../constants/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['commande_id'])) {

        $commande_id = $_POST['commande_id'];

        $validation_reussie = validerCommande($commande_id);


        if ($validation_reussie) {
            header('Location: commandes.php?commande=valide');
            exit();
        } else {

            header('Location: commandes.php?erreur=validation');
            exit();
        }
    }
} else {

    header("Location: details_commande.php?idd=$commande_id");
    exit();
}
?>
