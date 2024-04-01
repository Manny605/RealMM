<?php
session_start();

include '../constants/functions.php';

$allCategories = getAllCategories();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['ID_utilisateur'])) {

    header("Location: ../auth/login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
$user_id = $_SESSION['ID_utilisateur'];

// Récupérer les produits du panier
$panier_products = Panier($user_id);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre panier</title>
    <link rel="icon" type="image/x-icon" href="/MixMart/assets/logo2.jpg">
    <!-- Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        a,
        a:hover {
            text-decoration: none;
            color: inherit;
        }

        .col img{
            height:100px;
            width: 100%;
            cursor: pointer;
            transition: transform 1s;
            object-fit: cover;
        }
        .col label{
            overflow: hidden;
            position: relative;
        }
        .imgbgchk:checked + label>.tick_container{
            opacity: 1;
        }
        .imgbgchk:checked + label>img{
            transform: scale(1.25);
            opacity: 0.3;
        }
        .tick_container {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            cursor: pointer;
            text-align: center;
        }
        .tick {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 6px 12px;
            height: 40px;
            width: 40px;
            border-radius: 100%;
        }

    </style>

</head>
<body>

    <?php include '../components/Navbar.php'; ?>

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <?php if (empty($panier_products)) : ?>
                    <!-- En-tête si le panier est vide -->
                    <div class="alert alert-info" role="alert">
                        Votre panier est vide.
                    </div>
                <?php else : ?>
                    <!-- En-tête si le panier contient des produits -->
                    <form action="passer_la_commande.php" method="POST" enctype="multipart/form-data">
                        <h1 class="text-center mb-4">Votre <span class="text-warning">panier</span></h1>
                        <hr>
                        <div class="row">

                                <!-- Liste des produits dans le panier -->
                                <div class="col-md-12">
                                    <!-- Affichage de chaque produit -->
                                    <div class="bg-white rounded shadow p-4 mb-4">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Produit</th>
                                                        <th scope="col">Prix</th>
                                                        <th scope="col">Quantité</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total = 0; ?>
                                                    <?php foreach ($panier_products as $product) : ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="../admin/pages/produits/<?php echo $product['Image']; ?>" class="img-fluid me-2" alt="<?php echo $product['Nom']; ?>" style="max-width: 50px;">
                                                                    <span><?php echo $product['Nom']; ?></span>
                                                                </div>
                                                            </td>
                                                            <td data-price="<?php echo str_replace(',', '', $product['Prix']); ?>">
                                                                <?php echo $product['Prix']; ?> MRU
                                                                <input type="hidden" name="prix_unit[]" value="<?php echo $product['Prix']; ?>">
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="hidden" name="id[]" value="<?php echo $product['ID_produit']; ?>">
                                                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                                    <button type="button" class="btn btn-outline-secondary minus-btn" data-id="<?php echo $product['ID_produit']; ?>" onclick="updateQuantity(event, <?php echo $product['ID_produit']; ?>, -1)">-</button>
                                                                    <input type="number" class="form-control text-center quantity-input" id="quantity_<?php echo $product['ID_produit']; ?>" name="quantite[]" value="<?php echo $product['quantite']; ?>" aria-label="Quantité" style="width: 70px;">
                                                                    <button type="button" class="btn btn-outline-secondary plus-btn" data-id="<?php echo $product['ID_produit']; ?>" onclick="updateQuantity(event, <?php echo $product['ID_produit']; ?>, 1)">+</button>
                                                                </div>
                                                            </td>
                                                            <?php
                                                                $p = $product['quantite'] * $product['Prix'];
                                                                $total += $p;
                                                            ?>
                                                            <td id="total_<?php echo $product['ID_produit']; ?>" data-price="<?php echo $product['Prix']; ?>"><?php echo $p; ?> MRU</td>
                                                            <td>
                                                                <a href="remove_item.php?id=<?php echo $product['ID_produit']; ?>"><i class="text-danger fas fa-trash-alt"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations de paiement -->
                                <div class="col-md-12 mb-4">
                                    <div class="bg-white rounded shadow p-4">

                                        <div class="row">

                                            <!-- Carte de paiement 1 -->
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100 shadow rounded border-0">
                                                    <div class="bg-white text-center my-4">
                                                        <img src="../assets/bankily.png" alt="Bankily" class="img-fluid" style="max-width: 150px;">
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Détails de la carte de paiement 1 -->
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <label>Nom:</label>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 mr-2">Amb</p>
                                                                <button type="button" class="btn btn-sm border-0" onclick="copyText('Amb')">
                                                                    <i class="far fa-copy text-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <label>Tel :</label>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 mr-2">+222 ********</p>
                                                                <button type="button" class="btn btn-sm border-0" onclick="copyText('+222 ********')">
                                                                    <i class="far fa-copy text-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Carte de paiement 2 -->
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100 shadow rounded border-0">
                                                    <div class="bg-white text-center my-4">
                                                        <img src="../assets/masrivi.png" alt="Masrivi" class="img-fluid" style="max-width: 100px;">
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Détails de la carte de paiement 2 -->
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <label>Nom:</label>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 mr-2">Amb</p>
                                                                <button type="button" class="btn btn-sm border-0" onclick="copyText('Amb')">
                                                                    <i class="far fa-copy text-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <label>Tel :</label>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 mr-2">+222 ********</p>
                                                                <button type="button" class="btn btn-sm border-0" onclick="copyText('+222 ********')">
                                                                    <i class="far fa-copy text-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Carte de paiement 3 -->
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100 shadow rounded border-0">
                                                    <div class="bg-white text-center my-4">
                                                        <img src="../assets/whatsapp.png" alt="Bankily" class="img-fluid" style="max-width: 100px;">
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <a href="" class="btn btn-success"><i class="fa-brands fa-whatsapp"></i> Envoyer la commande</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nom_complet">Nom complet</label>
                                                <input type="text" class="form-control" id="nom_complet" name="nom_complet" placeholder="Entrez votre nom complet">
                                            </div>
                                            <div class="form-group">
                                                <label for="telPaiement">Téléphone</label>
                                                <input type="tel" class="form-control" id="telPaiement" name="telPaiement" placeholder="Entrez votre numéro de téléphone">
                                            </div>
                                            <!-- Input for Image -->
                                            <div class="form-group">
                                                <label for="screenshot">Capture d'écran du paiement</label>
                                                <input type="file" class="form-control" id="screenshot" name="screenshot" accept="image/*" required>
                                                <small class="form-text text-muted">Veuillez télécharger une capture d'écran de votre paiement.</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <!-- Résumé de la commande -->
                            <div class="col-md-12">
                                <!-- Sous-total, frais de livraison, total -->
                                <div class="bg-white rounded shadow p-4">
                                    <h2 class="h6">La commande</h2>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Sous-total</span>
                                        <span id="global-total"><?php echo $total; ?> MRU</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Livraison</span>
                                        <span>0 MRU</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="font-weight-bold">Total</span>
                                        <span class="font-weight-bold"><?php echo $total + 0; ?> MRU</span>
                                    </div>
                                    <button type="submit" class="btn btn-outline-warning btn-block mt-4">Passer la commande</button>
                                </div>
                            </div>

                        </div>
                    </form>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>




<!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function updateQuantity(event, productId, change) {
            const quantityInput = document.querySelector(`#quantity_${productId}`);
            let quantity = parseInt(quantityInput.value);
            quantity += change;
            
            // Mettre à jour l'affichage de la quantité
            quantityInput.value = quantity;

            // Envoyer une requête AJAX pour mettre à jour la quantité dans la base de données
            const formData = new FormData();
            formData.append('id', productId);
            formData.append('quantite', quantity);

            fetch('update_panier.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la mise à jour de la quantité.');
                }
                // Mettre à jour le total sur la page si nécessaire
                updateTotal(productId, quantity); // Appel de la fonction pour mettre à jour le total
            })
            .catch(error => {
                console.error('Erreur:', error);
                // En cas d'erreur, annuler la mise à jour de la quantité dans l'interface utilisateur
                quantityInput.value -= change;
            });
        }

        function updateTotal(productId, quantity) {
            const productPriceElement = document.querySelector(`#total_${productId}`);
            const productPrice = parseFloat(productPriceElement.getAttribute('data-price'));
            const totalElement = document.querySelector(`#total_${productId}`);
            const total = productPrice * quantity;
            totalElement.textContent = `${total.toFixed(2)} MRU`; // Assurez-vous que le total est formaté avec deux décimales

            // Recalculer le prix total global
            updateGlobalTotal();
        }

        function updateGlobalTotal() {
            let globalTotal = 0;
            document.querySelectorAll('tbody tr').forEach(row => {
                const price = parseFloat(row.querySelector('td[data-price]').getAttribute('data-price'));
                const quantity = parseInt(row.querySelector('.quantity-input').value);
                globalTotal += price * quantity;
            });

            // Afficher le prix total global
            const globalTotalElement = document.querySelector('#global-total');
            globalTotalElement.textContent = `${globalTotal.toFixed(2)} MRU`; // Assurez-vous que le total est formaté avec deux décimales
        }


        function copyText(text) {
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
        }

    </script>


</body>
</html>
