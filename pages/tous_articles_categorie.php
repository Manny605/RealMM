<?php

session_start();

include '../constants/functions.php';

$allCategories = getAllCategories();

if(isset($_GET['idc'])) {
    $categorie_id = $_GET['idc'];
    $produitsByCategorie = produitsByCategorie($categorie_id);
}

?>

<!doctype html>
<html lang="en">
<head>
    <title><?php echo isset($produitsByCategorie) && !empty($produitsByCategorie) ? $produitsByCategorie[0]['Nom_categorie'] : "Tous les produits"; ?></title>
    <link rel="icon" type="image/x-icon" href="/MixMart/assets/MixMart.png">

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

        body{
            font-family: 'poppins', sans-serif;
        }

        .container-fluid {
        padding: 0;
        }

        .header-image {
            background-image: linear-gradient(to right, #434343 0%, black 100%);
            width: 100%;
            max-height: 400px;
            background-size: cover;
            background-position: center;
        }

        .logo-img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
            transition : .3s
        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .top-50 {
            top: 50%;
        }

        .start-50 {
            left: 50%;
        }

        .translate-middle {
            transform: translate(-50%, -50%);
        }

        a,
        a:hover {
            text-decoration: none;
            color: inherit;
        }

        .section-products {
            padding: 80px 0 54px;
        }

        .section-products .header {
            margin-bottom: 50px;
        }

        .section-products .header h3 {
            font-size: 1rem;
            color: #fe302f;
            font-weight: 500;
        }

        .section-products .header h2 {
            font-size: 2.2rem;
            font-weight: 400;
            color: #444444; 
        }

        .section-products .single-product {
            margin-bottom: 26px;
        }

        .section-products .single-product .part-1 {
            position: relative;
            height: 290px;
            max-height: 290px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-products .single-product .part-1::before {
                position: absolute;
                content: "";
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                transition: all 0.3s;
        }

        .section-products .single-product:hover .part-1::before {
                transform: scale(1.2,1.2) rotate(5deg);
        }

        .section-products #product-1 .part-1::before {
            background-size: cover;
                transition: all 0.3s;
        }

        .section-products .single-product .part-1 .discount,
        .section-products .single-product .part-1 .new {
            position: absolute;
            top: 15px;
            left: 20px;
            color: #ffffff;
            background-color: #fe302f;
            padding: 2px 8px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .section-products .single-product .part-1 .new {
            left: 0;
            background-color: #444444;
        }

        .section-products .single-product .part-1 ul {
            position: absolute;
            bottom: -41px;
            left: 20px;
            margin: 0;
            padding: 0;
            list-style: none;
            opacity: 0;
            transition: bottom 0.5s, opacity 0.5s;
        }

        .section-products .single-product:hover .part-1 ul {
            bottom: 30px;
            opacity: 1;
        }

        .section-products .single-product .part-1 ul li {
            display: inline-block;
            margin-right: 4px;
        }

        .section-products .single-product .part-1 ul li a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            background-color: #ffffff;
            color: #444444;
            text-align: center;
            box-shadow: 0 2px 20px rgb(50 50 50 / 10%);
            transition: color 0.2s;
        }

        .section-products .single-product .part-1 ul li a:hover {
            color: #fe302f;
        }

        .section-products .single-product .part-2 .product-title {
            font-size: 1rem;
        }

        .section-products .single-product .part-2 h4 {
            display: inline-block;
            font-size: 1rem;
        }

        .section-products .single-product .part-2 .product-old-price {
            position: relative;
            padding: 0 7px;
            margin-right: 2px;
            opacity: 0.6;
        }

        .section-products .single-product .part-2 .product-old-price::after {
            position: absolute;
            content: "";
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #444444;
            transform: translateY(-50%);
        }
    </style>

</head>
<body>

    <?php include '../components/Navbar.php'; ?>

    <div class="container-fluid my-5">
        <div class="container">
            <?php if (!empty($produitsByCategorie)) : ?>
                <p class="display-4 text-center">Découvrez nos <span class="text-warning text-lowercase"><?php echo $produitsByCategorie[0]['Nom_categorie']; ?></span></p>
                <hr>
            <?php else : ?>
                <p class="display-4 text-center">Aucun produit disponible dans cette catégorie pour le moment.</p>
                <div class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <section class="section-products py-5">
        <div class="container">
            <form action="traitement_panier.php" method="POST">
                <div class="row g-4">
                    <?php foreach($produitsByCategorie as $product) : ?>
                        <div class="col-md-3">
                            <div id="product-<?php echo $product['ID_produit']; ?>" class="single-product card border-0">
                                <div class="part-1 card-img-top m-0 position-relative">
                                    <a href="details_produit.php?idp=<?php echo $product['ID_produit']; ?>">
                                        <img src="../admin/pages/produits/<?php echo $product['Image']; ?>" class="img-fluid d-block mx-auto" alt="<?php echo $product['Nom']; ?>" style="height: 200px;">
                                    </a>
                                    <input type="hidden" name="categorie_id" value="<?php echo $product['categorie_id']; ?>">
                                    <input type="hidden" name="quantite" value="1">
                                    <div class="overlay d-flex justify-content-center align-items-center">
                                        <ul class="list-unstyled">
                                            <li>
                                                <button type="submit" name="product_id" value="<?php echo $product['ID_produit']; ?>" class="btn btn-link text-dark">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </li>
                                            <li><a href="details_produit.php?idp=<?php echo $product['ID_produit']; ?>" class="text-dark"><i class="fas fa-search-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="part-2 card-body">
                                    <h3 class="product-title card-title"><?php echo $product['Nom']; ?></h3>
                                    <h4 class="product-price card-subtitle"><?php echo $product['Prix']; ?> MRU</h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>

    <script>

        <?php if (isset($_GET['add'])) : ?>
            Swal.fire({
                text: 'Produit ajouté',
                icon: 'success',
                timer: 2000
            }).then((result) => {
                window.history.replaceState({}, document.title, window.location.href.split('&')[0]);
            });
        <?php endif; ?>

        <?php if (isset($_GET['alreadyAdd'])) : ?>
            Swal.fire({
                text: 'Produit déjà ajouté',
                icon: '',
                timer: 2000
            }).then((result) => {
                window.history.replaceState({}, document.title, window.location.href.split('&')[0]);
            });
        <?php endif; ?>
        
    </script>

</body>
</html>
