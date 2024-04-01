<?php
// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=mixmart", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de l'existence des données du formulaire
    if (isset($_POST['user_id'], $_POST['nom_complet'], $_POST['telPaiement'], $_FILES['screenshot'], $_POST['id'], $_POST['quantite'], $_POST['prix_unit'])) {

        // Récupération des données du formulaire
        $user_id = $_POST['user_id'];
        $nom_complet = $_POST['nom_complet'];
        $tel_paiement = $_POST['telPaiement'];
        $screenshot = $_FILES['screenshot']['name']; // Nom du fichier téléchargé
        $upload_path = $_FILES['screenshot']['tmp_name']; // Chemin temporaire du fichier téléchargé
        $id_produits = $_POST['id'];
        $quantites = $_POST['quantite'];
        $prix_unitaires = $_POST['prix_unit'];

        // Vérification si les tableaux de quantités et de prix unitaires ont la même longueur
        if (count($quantites) === count($prix_unitaires)) {
            try {
                // Début de la transaction
                $pdo->beginTransaction();

                // Insertion des données de la commande dans la table "commande"
                $query_commande = "INSERT INTO commande (utilisateur_id, DateCommande, StatutCommande, NomCompletPaiement, TelephonePaiement, ScreenshotPaiement) VALUES (:user_id, NOW(), 'En attente', :nom_complet, :tel_paiement, :screenshot)";
                $stmt_commande = $pdo->prepare($query_commande);
                $stmt_commande->execute(array(
                    ':user_id' => $user_id,
                    ':nom_complet' => $nom_complet,
                    ':tel_paiement' => $tel_paiement,
                    ':screenshot' => $screenshot
                ));

                // Récupération de l'ID de la commande nouvellement insérée
                $id_commande = $pdo->lastInsertId();

                // Insertion des détails de la commande dans la table "detail_commande" pour chaque produit dans le panier
                foreach ($id_produits as $key => $id_produit) {
                    $quantite = $quantites[$key];
                    $prix_unitaire = $prix_unitaires[$key];

                    // Calcul du prix total pour cet article
                    $prix_total = $quantite * $prix_unitaire;

                    $query_detail_commande = "INSERT INTO detailcommande (ID_commande, ID_produit, Quantite, PrixUnitaire) VALUES (:id_commande, :id_produit, :quantite, :prix_unitaire)";
                    $stmt_detail_commande = $pdo->prepare($query_detail_commande);
                    $stmt_detail_commande->execute(array(
                        ':id_commande' => $id_commande,
                        ':id_produit' => $id_produit,
                        ':quantite' => $quantite,
                        ':prix_unitaire' => $prix_unitaire
                    ));
                }

                // Déplacement du fichier téléchargé vers un dossier de destination
                $destination = 'screenshots/';
                move_uploaded_file($upload_path, $destination . $screenshot);

                // Suppression des entrées du panier après la validation de la commande
                $query_suppression_panier = "DELETE FROM panier WHERE utilisateur_id = :user_id";
                $stmt_suppression_panier = $pdo->prepare($query_suppression_panier);
                $stmt_suppression_panier->execute(array(':user_id' => $user_id));

                // Validation de la transaction
                $pdo->commit();

                // Réponse de succès
                header("Location: accueil.php?success=ok");
                exit();

            } catch (PDOException $e) {
                $pdo->rollBack();
                header("Location: panier.php?error=fichier1");
                exit();
            }
        } else {
            // Les tableaux de quantités et de prix unitaires n'ont pas la même longueur
            header("Location: panier.php?error=donnees_invalides");
            exit();
        }
    } else {
        // Données manquantes dans le formulaire
        header("Location: panier.php?error=manques");
        exit();
    }
} else {
    // Méthode de requête non autorisée
    header("Location: panier.php?error=fichier2");
    exit();
}
?>
