<?php 

session_start();

include '../constants/functions.php';

$allCategories = getAllCategories();

if(isset($_GET['idp'])) {
    $product_id = $_GET['idp'];
    $product_details = detailsProduit($product_id);
    $simulaireProducts = similarProducts($product_details['categorie_id']);
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?php echo $product_details['Nom']; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/MixMart/assets/logo2.jpg">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        a,
        a:hover {
            text-decoration: none;
            color: inherit;
        }

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

        <section class="py-5">
            <form action="traitement_panier.php" method="POST">
                <div class="container px-4 px-lg-5 my-5">
                    <?php if(isset($product_details)): ?>
                    <div class="row gx-4 gx-lg-5 align-items-center">
                            <div class="col-md-6">
                                <img class="card-img-top mb-5 mb-md-0" src="../admin/pages/produits/<?php echo $product_details['Image']; ?>" alt="Product Image">
                            </div>
                            <div class="col-md-6">
                                <h1 class="display-5 fw-bolder text-warning"><?php echo $product_details['Nom']; ?></h1>
                                <div class="fs-5 mb-5">
                                    <span><?php echo $product_details['Prix']; ?> MRU</span>
                                </div>
                                <p class="lead"><?php echo $product_details['Description']; ?></p>
                                <div class="d-flex">
                                    <input type="hidden" name="categorie_id" value="<?php echo $product_details['categorie_id']; ?>">
                                    <input class="form-control text-center me-3" name="quantite" id="inputQuantity" type="number" value="1" min="1" style="max-width: 3rem">
                                    <div class="mx-3"></div>
                                    <button type="submit" name="product_id" value="<?php echo $product_details['ID_produit']; ?>" class="btn btn-outline-dark ms-4 flex-shrink-0">
                                        <i class="bi-cart-fill me-1"></i>
                                        Acheter
                                    </button>
                                </div>
                            </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col">
                            <p>Aucun produit trouve</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </section>


        <section>

            <div class="container d-flex flex-column align-items-center mb-5">
                <h2 class="display-4 text-warning">Articles Similaires</h2>
                <hr>
                <p class="lead">Explorez notre sélection d'articles similaires pour découvrir encore plus de ce que vous aimez.</p>
            </div>

        </section>

        <section class="section-products py-5">
            <div class="container">
                <form action="traitement_panier.php" method="POST">
                    <div class="row g-4">
                        <?php foreach($simulaireProducts as $product) : ?>
                            <div class="col-md-3">
                                <div id="product-<?php echo $product['ID_produit']; ?>" class="single-product card border-0">
                                    <div class="part-1 card-img-top m-0 position-relative">
                                        <a href="details_produit.php?idp=<?php echo $product['ID_produit']; ?>">
                                            <img src="../admin/pages/produits/<?php echo $product['Image']; ?>" class="img-fluid d-block mx-auto" alt="<?php echo $product['Nom']; ?>" style="height: 200px;">
                                        </a>
                                        <input type="hidden" name="categorie_id" value="<?php echo $product['categorie_id']; ?>">
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

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
