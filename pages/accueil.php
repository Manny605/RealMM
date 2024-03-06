<?php

session_start();

include '../constants/functions.php';

$allCategories = getAllCategories();
$NewArrivals = NewArrivals();

?>

<!doctype html>
<html lang="en">
<head>
    <title>Accueil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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

        <div class="container-fluid header-image vh-100 position-relative">
            <div class="position-absolute top-50 start-50 translate-middle text-center text-light">
                <h2 class="display-4">Nouvelles Arrivées</h2>
                <p class="lead text-warning">Trouvez vos articles préférés dès maintenant</p>
                <a class="btn btn-outline-light border-light rounded-0">Découvrir</a>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row justify-content-around">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-truck fa-2x text-danger"></i>
                            </div>
                            <div>
                                <p class="lead m-0">Livraison gratuite</p>
                                <p class="text-muted">Profitez de la livraison gratuite sur toutes vos commandes.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-money-bill-wave fa-2x text-sucess"></i>
                            </div>
                            <div>
                                <p class="lead m-0">Remboursement facile</p>
                                <p class="text-muted">Retournez vos produits facilement et obtenez un remboursement complet.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-headset fa-2x text-warning"></i>
                            </div>
                            <div>
                                <p class="lead m-0">Support 24h/24, 7j/7</p>
                                <p class="text-muted">Notre équipe de support client est disponible à tout moment pour vous aider.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid my-5">
            <div class="container">
                <p class="display-4 text-center">Découvrez nos dernières <span class="text-warning">collections</span></p>
                <hr>
            </div>
        </div>


        <section class="section-products py-5">
    <div class="container">
        <?php $currentCategory = ''; ?>
        <div class="row g-4">
            <?php foreach($NewArrivals as $newProduct) : ?>
                <?php if ($newProduct['Nom_categorie'] != $currentCategory) : ?>
                    <?php $currentCategory = $newProduct['Nom_categorie']; ?>
                    <div class="col-12">
                        <h2 class="category-label"><?php echo $currentCategory; ?></h2>
                    </div>
                <?php endif; ?>
                <div class="col-md-3">
                    <div id="product-<?php echo $newProduct['ID_produit']; ?>" class="single-product card border-0">
                        <div class="part-1 card-img-top m-0 position-relative">
                            <img src="../admin/pages/produits/<?php echo $newProduct['Image']; ?>" class="img-fluid d-block mx-auto" alt="Product Image" style="height: 200px;">
                            <div class="overlay d-flex justify-content-center align-items-center">
                                <ul class="list-unstyled">
                                    <li><a href="#" class="text-dark"><i class="fas fa-shopping-cart"></i></a></li>
                                    <li><a href="#" class="text-dark"><i class="fas fa-search-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="part-2 card-body">
                            <h3 class="product-title card-title"><?php echo $newProduct['Nom']; ?></h3>
                            <h4 class="product-price card-subtitle"><?php echo $newProduct['Prix']; ?> MRU</h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>






<!-- <div class="container my-4">
    <div class="row">

        <div class="col-md-4">
            <a href="#" class="card bg-dark text-white mb-4">
                <img class="card-img" src="../assets/legumes.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h2 class="card-title">Legumes</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="#" class="card bg-dark text-white mb-4">
                <img class="card-img" src="../assets/chinese.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h2 class="card-title">Chinese</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="#" class="card bg-dark text-white mb-4">
                <img class="card-img" src="../assets/clothes.jpeg" alt="Card image">
                <div class="card-img-overlay">
                    <h2 class="card-title">Vetements</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="#" class="card bg-dark text-white mb-4">
                <img class="card-img" src="../assets/babywear.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h2 class="card-title">Vetements de bebe</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="#" class="card bg-dark text-white mb-4">
                <img class="card-img" src="../assets/SkinCare.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h2 class="card-title">SkinCare</h5>
                </div>
            </a>
        </div>

    </div>
</div> -->

<?php include '../components/footer.php'; ?>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
    ></script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
