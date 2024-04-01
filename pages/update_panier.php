<?php

include '../constants/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['quantite'])) {
    $product_id = $_POST['id'];
    $new_quantity = $_POST['quantite'];

    // Mettre à jour la quantité dans la base de données
    if (updateQuantityInDatabase($product_id, $new_quantity)) {
        echo json_encode(array("success" => true));
        header('Location: panier.php');
    } else {
        // Envoyer une réponse JSON pour indiquer que la mise à jour a échoué
        echo json_encode(array("success" => false));
    }
} else {
    // Envoyer une réponse JSON pour indiquer une erreur de requête
    echo json_encode(array("error" => "Mauvaise requête"));
}
?>
