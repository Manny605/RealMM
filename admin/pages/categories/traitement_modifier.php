<?php
session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: /MixMart/auth/login.php');
    exit();
}


if(isset($_POST['id_categorie'], $_POST['nom_categorie'])) {
    $id = $_POST['id_categorie'];
    $nom = $_POST['nom_categorie'];

    // File upload handling
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_directory = 'images/';
        $new_image_path = $upload_directory . basename($_FILES['image']['name']);
        
        // Move uploaded file to the upload directory
        if(move_uploaded_file($_FILES['image']['tmp_name'], $new_image_path)) {
            // File uploaded successfully, update image path in database
            $image = $new_image_path;
        } else {
            // Error handling for file move failure
            echo "Error moving file.";
            exit(); // Terminate script execution
        }
    } else {
        // No new image uploaded, retain the existing image
        $image = $_POST['image_existing'];
    }

    include '../../../constants/functions.php';
    $connect = connect();

    $sql = "UPDATE categorie SET Nom = :nom, Image = :image WHERE ID_categorie = :id";
    $stmt = $connect->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':image', $image, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if($stmt->rowCount() > 0) {
        header("Location: categories.php?success_modif=ok");
        exit();
    } else {
        header("Location: categories.php?error_modif=error1");
        exit();
    }
} else {
    // Handle the case where form data is missing
    // You may want to redirect the user to a proper error page
    header("Location: categories.php?error_modif=error2");
    exit();
}
?>
