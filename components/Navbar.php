<nav class="navbar navbar-expand-lg navbar-light bg-white">

  <!-- Brand/logo -->
  <a class="navbar-brand text-warning" href="/MixMart/pages/accueil.php">
    MIXMART
  </a>

  <!-- Toggle button for small screens -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navigation links and search bar -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/MixMart/pages/accueil.php">Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/MixMart/pages/boutique.php">Boutique</a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categories
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
              <?php foreach($allCategories as $categorie) : ?>
                  <div class="dropdown-item">
                      <a href="#"><?php echo $categorie['Nom']; ?></a>
                  </div>
              <?php endforeach; ?>
          </div>
      </li>
    </ul>

    <!-- Search form -->
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Rechercher..." aria-label="Search">
      <button class="btn btn-outline-warning my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
    </form>

    <!-- User profile and account -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i>        
        </a>
          <?php 
            if(!isset($_SESSION['ID_utilisateur'])) {
              print '
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
                <a class="dropdown-item" href="/MixMart/auth/login.php">Se connecter</a>
                <a class="dropdown-item" href="/MixMart/auth/register.php">S\'inscrire</a>
              </div>
              ';
            } else {

              if($_SESSION['Statut'] == 'admin'){
                print '
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
                  <a class="dropdown-item" href="/MixMart/admin/index.php">Profile</a>
                  <a class="dropdown-item text-danger" href="/MixMart/auth/deconnexion.php">Deconnexion</a>
                </div>
                ';
              } else {
                print '
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
                  <a class="dropdown-item" href="/MixMart/pages/account/profile.php">Profile</a>
                  <a class="dropdown-item text-danger" href="/MixMart/auth/deconnexion.php">Deconnexion</a>
                </div>
                ';
              }

            }
          ?>
      </li>
    </ul>
  </div>
</nav>
