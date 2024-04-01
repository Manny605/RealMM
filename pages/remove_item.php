<?php 

include '../constants/functions.php';

if(isset($_GET['id'])) {

    $product_id = $_GET['id'];

    if(deleteFromPanier($product_id)) {
        header("Location: panier.php");
        exit();
    } else {
        header("Location: panier.php?error");
        exit();
    }

}

?>