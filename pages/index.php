<?php 
include '../constants/functions.php';

// Retrieve categories
try {
    $allCategories = getAllCategories();
} catch (Exception $e) {
    echo "Error fetching categories: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MIXMART</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="/MixMart/assets/MixMart.png">


  <style>
    /* Ajouter un espace au-dessus du jumbotron */
    .jumbotron-container {
      margin-top: 50px; /* Vous pouvez ajuster cette valeur selon vos besoins */
    }

    /* Ajouter un espace en dessous du container */
    #categoryContainer {
      margin-bottom: 50px; /* Vous pouvez ajuster cette valeur selon vos besoins */
    }

    /* Le reste de votre CSS */
    .jumbotron-image {
          max-width: 400px;
          height: auto;
          margin-bottom: 20px;
          border-radius: 1000px;
        }

        .arrow-container {
          position: fixed;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          cursor: pointer;
          animation: bounce 1.5s infinite;
        }

        .custom-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15), 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .custom-card .card-img {
            transition: transform 0.5s ease;
        }

        .custom-card:hover .card-img {
            transform: scale(1.05);
        }

        .card-overlay-content {
            background-color: rgba(0, 0, 0, 0.7); /* Couleur du fond semi-transparent */
            padding: 10px; /* Ajoute un espace autour du titre */
            border-radius: 0 0 10px 10px; /* Arrondi le coin bas des cartes */
        }

        .card-title {
            margin-bottom: 0; /* Supprime la marge en bas du titre */
        }

        @keyframes bounce {
          0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
          }
          40% {
            transform: translateY(-20px);
          }
          60% {
            transform: translateY(-10px);
          }
        }
  </style>

</head>


<body>

<!-- Jumbotron -->
<div class="jumbotron-container container-fluid m-0 text-center d-flex flex-column align-items-center justify-content-center vh-100">
  <img src="../assets/logo2.jpg" alt="MIXMART Logo" class="jumbotron-image">
  <h1 class="display-4">Bienvenue sur <span class="text-warning">MIXMART</span></h1>
  <p class="lead">Trouvez ce que vous cherchez parmi notre large sélection de produits de qualité.</p>
</div>

<div class="arrow-container">
  <span id="arrow" class="arrow">&#9660;</span>
</div>

<div class="my-5"></div>

<!-- Category container -->
<div id="categoryContainer" class="container my-4 hidden">
    <div class="row">
        <?php foreach($allCategories as $categorie) : ?>
            <div class="col-md-4">
                <a href="tous_articles_categorie.php?idc=<?php echo $categorie['ID_categorie']; ?>" class="card bg-dark text-white mb-4 custom-card">
                    <img class="card-img" src="../admin/pages/categories/<?php echo $categorie['Image']; ?>" alt="<?php echo $categorie['Nom']; ?>" style="height: 200px;">
                    <div class="card-img-overlay">
                        <div class="card-overlay-content">
                            <h2 class="card-title"><?php echo $categorie['Nom']; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script for scrolling -->
<script>
  // Function to show the arrow when scrolling up
  function showArrow() {
    document.getElementById('arrow').style.display = 'block';
  }

  // Add event listener for scrolling
  window.addEventListener('scroll', function() {
    // Check if the page has been scrolled
    if (window.scrollY > 0) {
      hideArrow(); // Hide the arrow if scrolled
    } else {
      showArrow(); // Show the arrow if scrolled to the top
    }
  });

  // Add event listener to the arrow for scrolling
  document.getElementById('arrow').addEventListener('click', function() {
    // Remove the hidden class from the category container
    document.getElementById('categoryContainer').classList.remove('hidden');

    // Scroll to the category container
    document.getElementById('categoryContainer').scrollIntoView({
      behavior: 'smooth'
    });

    // Hide the arrow after clicking
    hideArrow();
  });
</script>


</body>
</html>
