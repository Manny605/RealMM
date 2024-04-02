<?php

// Fonction de connexion à la base de données
function connect() {
    $host = 'localhost'; // ou le nom de l'hôte si différent
    $dbname = 'mixmart';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Définir le mode d'erreur PDO sur Exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}





//-----------------Authentification-------------------------
function authentifier_user($identifiant, $mot_de_passe) {
    $connect = connect();
    
    // Prévenir les injections SQL
    $stmt = $connect->prepare("SELECT * FROM utilisateur WHERE (Nom_utilisateur = :identifiant OR Phone = :identifiant)");
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->execute();
    
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultat) {

        if (password_verify($mot_de_passe, $resultat['MotDePasse'])) {
            $_SESSION['ID_utilisateur'] = $resultat['ID_utilisateur'];
            $_SESSION['Prenom'] = $resultat['Prenom'];
            $_SESSION['Nom'] = $resultat['Nom'];
            $_SESSION['Nom_utilisateur'] = $resultat['Nom_utilisateur'];
            $_SESSION['Phone'] = $resultat['Phone'];
            $_SESSION['Statut'] = $resultat['Statut'];
            return true;
        }
    }
    
    return false;
}

//-----------------Registration--------------------------

function register($prenom, $nom, $tel, $nom_user, $mdp) {
        try {
            // Connexion à la base de données avec PDO
            $pdo = new PDO("mysql:host=localhost;dbname=mixmart", "root", "");
            // Définir le mode d'erreur PDO sur Exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparer la requête d'insertion avec des paramètres
            $stmt = $pdo->prepare("INSERT INTO utilisateur (Prenom, Nom, Nom_utilisateur, Phone, MotDePasse, Statut) 
                                VALUES (:prenom, :nom, :nom_user, :tel, :mdp, 'client')");

            // Liage des valeurs des paramètres
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':nom_user', $nom_user);
            // Pour des raisons de sécurité, il est recommandé de hacher les mots de passe avant de les stocker en base de données
            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt->bindParam(':mdp', $mdp_hash);

            // Exécuter la requête
            $stmt->execute();

            return true; // Succès de l'insertion
        } catch(PDOException $e) {
            // En cas d'erreur, afficher ou journaliser le message d'erreur
            echo "Erreur lors de l'insertion des données : " . $e->getMessage();
            return false; // Échec de l'insertion
        }
}


//----------------Some GET for some sections------------

function NewArrivals() {
    $connect = connect(); 

    // Requête pour sélectionner les 4 premiers produits pour chaque catégorie avec la date de création et le chemin de l'image
    $sql = "SELECT *
            FROM (
                SELECT p.ID_produit, p.categorie_id, c.Nom AS Nom_categorie ,p.Nom, p.Description, p.Prix, p.Stock, p.Image, p.DateCreation,
                    ROW_NUMBER() OVER(PARTITION BY p.categorie_id ORDER BY p.DateCreation DESC) AS row_num
                FROM produit p
                JOIN categorie c ON p.categorie_id = c.ID_categorie
            ) AS subquery
            WHERE row_num <= 4";

    // Exécuter la requête SQL
    $stmt = $connect->query($sql);

    // Récupérer les résultats
    $newArrivals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fermer la connexion
    $connect = null;

    return $newArrivals;
}


function similarProducts($categorie_id){
    $connect = connect();

    // Préparez la requête SQL pour récupérer les articles de la catégorie spécifiée avec les détails de l'auteur
    $sql = "SELECT produit.*, categorie.Nom AS Nom_categorie 
            FROM produit
            INNER JOIN categorie ON produit.categorie_id = categorie.ID_categorie
            WHERE produit.categorie_id = :categorie_id ORDER BY DateCreation DESC LIMIT 4";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bindValue(':categorie_id', $categorie_id, PDO::PARAM_INT);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fermez la connexion
    $connect = null;

    // Retourner les articles
    return $result;
}






//--------------------C-------------------------

function insertProduit($nom, $description, $prix, $stock, $categorie, $image) {
    // Connexion à la base de données
    $connect = connect();

    // Préparation de la requête SQL
    $sql = "INSERT INTO produit (categorie_id ,Nom, Description, Prix, Stock, Image) VALUES (?, ?, ?, ?, ?, ?)";

    // Préparation de la déclaration
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(1, $categorie);
    $stmt->bindParam(2, $nom);
    $stmt->bindParam(3, $description);
    $stmt->bindParam(4, $prix);
    $stmt->bindParam(5, $stock);
    $stmt->bindParam(6, $image);

    // Exécution de la requête
    if ($stmt->execute()) {
        return true; // Succès de l'insertion
    } else {
        return false; // Échec de l'insertion
    }

    // Fermeture de la connexion et de la déclaration
    $stmt->close();
    $connect = null;
}

function insertCategorie($nom_categorie, $image) {
    
    $connect = connect();

    $sql = "INSERT INTO categorie (Nom, Image) VALUES (?,?)";

    $result = $connect->prepare($sql);

    $result->bindParam(1, $nom_categorie);
    $result->bindParam(2, $image);

    if($result->execute()){
        return true;
    }else {
        return false;
    }

    $result->close();

    $connect = null;


}

function insertDansPanier($user_id, $product_id, $quantite) {
    $connect = connect();

    try {
        // Vérifier si l'utilisateur a déjà un panier
        $query_check_panier = "SELECT ID_panier FROM Panier WHERE utilisateur_id = :user_id";
        $stmt_check_panier = $connect->prepare($query_check_panier);
        $stmt_check_panier->execute(['user_id' => $user_id]);
        $row = $stmt_check_panier->fetch(PDO::FETCH_ASSOC);

        if ($stmt_check_panier->rowCount() == 0) {
            // Si l'utilisateur n'a pas encore de panier, créer un nouveau panier
            $query_create_panier = "INSERT INTO Panier (utilisateur_id) VALUES (:user_id)";
            $stmt_create_panier = $connect->prepare($query_create_panier);
            $stmt_create_panier->execute(['user_id' => $user_id]);

            // Récupérer l'ID du panier nouvellement créé
            $panier_id = $connect->lastInsertId();
        } else {
            // Récupérer l'ID du panier existant de l'utilisateur
            $panier_id = $row['ID_panier'];
        }

        // Vérifier si le produit est déjà dans le panier de l'utilisateur
        $query_check_produit = "SELECT quantite FROM produitdanspanier WHERE panier_id = :panier_id AND produit_id = :product_id";
        $stmt_check_produit = $connect->prepare($query_check_produit);
        $stmt_check_produit->execute(['panier_id' => $panier_id, 'product_id' => $product_id]);
        $row = $stmt_check_produit->fetch(PDO::FETCH_ASSOC);

        if ($stmt_check_produit->rowCount() > 0) {
            // Si le produit est déjà dans le panier, incrémenter la quantité
            $query_update_quantite = "UPDATE produitdanspanier SET quantite = quantite + 1 WHERE panier_id = :panier_id AND produit_id = :product_id";
            $stmt_update_quantite = $connect->prepare($query_update_quantite);
            $stmt_update_quantite->execute(['panier_id' => $panier_id, 'product_id' => $product_id]);
        } else {
            // Sinon, insérer le produit dans le panier avec une quantité de 1
            $query_insert_produit = "INSERT INTO produitdanspanier (panier_id, produit_id, quantite) VALUES (:panier_id, :product_id, :quantite)";
            $stmt_insert_produit = $connect->prepare($query_insert_produit);
            $stmt_insert_produit->execute(['panier_id' => $panier_id, 'product_id' => $product_id, 'quantite' => $quantite]);
        }

        return true; // Produit ajouté avec succès
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur ou journaliser l'erreur
        error_log("Erreur lors de l'ajout du produit au panier: " . $e->getMessage(), 0);
        return false; // Erreur lors de l'ajout du produit
    }
}

function insertCommande($user_id, $product_id, $quantite, $prix_unit, $nom_complet, $telPaiement, $screenshot) {
    try {
        // Connexion à la base de données
        $connect = connect();

        // Requête d'insertion pour la table 'commande'
        $query_commande = "INSERT INTO commande (utilisateur_id, DateCommande, StatutCommande, NomCompletPaiement, TelephonePaiement, ScreenshotPaiement) 
                            VALUES (:user_id, NOW(), 'En attente', :nom_complet, :telPaiement, :screenshot)";
        $statement_commande = $connect->prepare($query_commande);

        // Liaison des paramètres de la requête avec les valeurs fournies
        $statement_commande->bindParam(':user_id', $user_id);
        $statement_commande->bindParam(':nom_complet', $nom_complet);
        $statement_commande->bindParam(':telPaiement', $telPaiement);
        $statement_commande->bindParam(':screenshot', $screenshot);

        // Exécution de la requête d'insertion pour la table 'commande'
        $result_commande = $statement_commande->execute();

        // Récupération de l'ID de la commande insérée
        $commande_id = $connect->lastInsertId();

        // Requête d'insertion pour la table 'detailcommande'
        $query_detail = "INSERT INTO detailcommande (ID_commande, ID_produit, Quantite, PrixUnitaire) 
                            VALUES (:commande_id, :product_id, :quantite, :prix_unit)";
        $statement_detail = $connect->prepare($query_detail);

        
        
        // Liaison des paramètres de la requête avec les valeurs fournies
        $statement_detail->bindParam(':commande_id', $commande_id);
        $statement_detail->bindParam(':product_id', $product_id);
        $statement_detail->bindParam(':quantite', $quantite);
        $statement_detail->bindParam(':prix_unit', $prix_unit);

        // Exécution de la requête d'insertion pour la table 'detailcommande'
        $result_detail = $statement_detail->execute();

        // Retourner true si les deux insertions ont réussi, sinon false
        return $result_commande && $result_detail;
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        // Vous pouvez enregistrer les erreurs dans un fichier de journal ou les afficher pour le débogage
        // echo "Erreur de base de données : " . $e->getMessage();
        return false; // Échec de l'insertion
    }
}

//-------------------R-------------------------

function GetAllProducts() {
    $connect = connect();
    
    $sql = "SELECT produit.*, categorie.Nom AS Nom_categorie FROM produit
    INNER JOIN categorie ON produit.categorie_id = categorie.ID_categorie
    ORDER BY DateCreation DESC";
    
    $stmt = $connect->query($sql);
    
    $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $connect = null;
    
    return $allProducts;
}

function getAllCategories() {
    $connect = connect();

    $sql = "SELECT * FROM categorie";

    $result = $connect->query($sql);

    $allCategories = $result->fetchAll(PDO::FETCH_ASSOC);

    $connect = null;

    return $allCategories;
}

function getAllCommandesEnAttente(){
    $connect = connect();
    
    $sql = "SELECT commande.*, produit.Nom, CONCAT(utilisateur.Prenom, ' ', utilisateur.Nom) AS Client, COUNT(detailcommande.ID_detail_commande) AS nbr_produits FROM commande
    INNER JOIN detailcommande ON detailcommande.ID_commande = commande.ID_commande
    INNER JOIN produit ON produit.ID_produit = detailcommande.ID_produit
    INNER JOIN utilisateur ON utilisateur.ID_utilisateur = commande.utilisateur_id
    WHERE commande.StatutCommande = 'En attente'
    ORDER BY DateCommande DESC";
    
    $stmt = $connect->query($sql);
    
    $allCommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $connect = null;
    
    return $allCommandes;
}

function getAllCommandesValidee(){
    $connect = connect();
    
    $sql = "SELECT commande.*, produit.Nom, CONCAT(utilisateur.Prenom, ' ', utilisateur.Nom) AS Client, COUNT(detailcommande.ID_detail_commande) AS nbr_produits FROM commande
    INNER JOIN detailcommande ON detailcommande.ID_commande = commande.ID_commande
    INNER JOIN produit ON produit.ID_produit = detailcommande.ID_produit
    INNER JOIN utilisateur ON utilisateur.ID_utilisateur = commande.utilisateur_id
    WHERE commande.StatutCommande = 'validee'
    ORDER BY DateCommande DESC";
    
    $stmt = $connect->query($sql);
    
    $allCommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $connect = null;
    
    return $allCommandes;
}

function getAllClients(){
    $connect = connect();

    $sql = "SELECT * FROM utilisateur WHERE Statut = 'client' ";

    $stmt = $connect->query($sql);

    $allClients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $connect = null;

    return $allClients;
}

function getDetailsCommande($commande_id){
    $connect = connect();

    $sql = "SELECT dc.*, p.*, c.*, ct.Nom as Nom_categorie FROM detailcommande dc 
    INNER JOIN commande c ON c.ID_commande = dc.ID_commande
    INNER JOIN produit p ON p.ID_produit = dc.ID_produit
    INNER JOIN categorie ct ON ct.ID_categorie = p.categorie_id
    WHERE dc.ID_commande = :commande_id";

    try {
        $stmt = $connect->prepare($sql);

        $stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);

        $stmt->execute();

        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $details;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

function DetailsPaiement($commande_id){
    // Establish a database connection
    try {
        $connect = new PDO("mysql:host=localhost;dbname=mixmart", "root", "");
        // Set PDO to throw exceptions on error
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to select details of the payment
        $sql = "SELECT * FROM commande WHERE ID_commande = :commande_id";

        // Prepare the SQL statement
        $stmt = $connect->prepare($sql);

        // Bind the parameter
        $stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the first row as associative array
        $details = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $connect = null;

        return $details;
    } catch(PDOException $e) {
        // If an error occurs, catch it and return null
        echo "Error: " . $e->getMessage();
        return null;
    }
}




function produitsByCategorie($categorie_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer les articles de la catégorie spécifiée avec les détails de l'auteur
    $sql = "SELECT produit.*, categorie.Nom AS Nom_categorie 
            FROM produit
            INNER JOIN categorie ON produit.categorie_id = categorie.ID_categorie
            WHERE produit.categorie_id = :categorie_id ORDER BY DateCreation DESC";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bindValue(':categorie_id', $categorie_id, PDO::PARAM_INT);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fermez la connexion
    $connect = null;

    // Retourner les articles
    return $result;
}


function detailsProduit($produit_id) {
    $connect = connect();

    // Préparez la requête SQL pour récupérer les détails du produit spécifié
    $sql = "SELECT * FROM produit WHERE ID_produit = :produit_id";

    // Préparez la déclaration SQL
    $stmt = $connect->prepare($sql);

    // Liaison des paramètres
    $stmt->bindValue(':produit_id', $produit_id, PDO::PARAM_INT);

    // Exécutez la déclaration
    $stmt->execute();

    // Obtenez le résultat de la requête
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fermez la connexion
    $connect = null;

    // Retourner les détails du produit
    return $result;
}

function Panier($user_id) {
    $connect = connect();

    try {
        // Vérifier si l'utilisateur a un panier
        $query_check_panier = "SELECT ID_panier FROM Panier WHERE utilisateur_id = :user_id";
        $stmt_check_panier = $connect->prepare($query_check_panier);
        $stmt_check_panier->execute(['user_id' => $user_id]);
        $row = $stmt_check_panier->fetch(PDO::FETCH_ASSOC);

        if ($stmt_check_panier->rowCount() == 0) {
            // Si l'utilisateur n'a pas de panier, retourner un tableau vide
            return [];
        } else {
            // Si l'utilisateur a un panier, récupérer les produits du panier
            $panier_id = $row['ID_panier'];
            $sql = "SELECT produitdanspanier.*, produit.* 
                    FROM produitdanspanier
                    INNER JOIN produit ON produitdanspanier.produit_id = produit.ID_produit
                    WHERE produitdanspanier.panier_id = :panier_id";
            $stmt = $connect->prepare($sql);
            $stmt->execute(['panier_id' => $panier_id]);
            $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $panier;
        }
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur ou journaliser l'erreur
        error_log("Erreur lors de la récupération du panier: " . $e->getMessage(), 0);
        return false; // Retourner false en cas d'erreur
    }
}



//----------------U---------------------------

function updateQuantityInDatabase($product_id, $new_quantity) {
    try {
        $connect = connect();

        $stmt = $connect->prepare("UPDATE produitdanspanier SET quantite = :new_quantity WHERE produit_id = :product_id");
        $stmt->bindParam(':new_quantity', $new_quantity);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        // Fermer la connexion à la base de données
        $connect = null;

        // Retourner true si la mise à jour a réussi
        return true;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher l'erreur et retourner false
        echo "Erreur de mise à jour du panier: " . $e->getMessage();
        return false;
    }
}

function validerCommande($commande_id) {

    $connect = connect();

    // Préparer la requête SQL pour mettre à jour le statut de la commande
    $sql = "UPDATE commande SET StatutCommande = 'validee' WHERE ID_commande = :commande_id";

    try {
        // Préparer la requête
        $stmt = $connect->prepare($sql);
        
        // Lié le paramètre de l'identifiant de la commande
        $stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
        
        // Exécuter la requête
        $stmt->execute();

        // Retourner true si la mise à jour a réussi
        return true;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, afficher l'erreur et retourner false
        echo "Error updating record: " . $e->getMessage();
        return false;
    }

    // Fermer la connexion à la base de données
    $connect = null;
}


//----------------D--------------------------

function deleteFromPanier($product_id){
    $connect = connect();

    $sql = "DELETE FROM produitdanspanier WHERE produit_id = :produit_id";

    $stmt = $connect->prepare($sql);

    $stmt->bindParam(':produit_id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}




?>
