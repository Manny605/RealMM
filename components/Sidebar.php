<!-- Sidebar -->
<ul class="navbar-nav bg-light sidebar sidebar-light accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/MixMart/pages/accueil.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3 text-warning">MIXMART</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">
        <a class="nav-link" href="/MixMart/admin/index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sections
    </div>

    <!-- Nav Item - Products Collapse Menu -->
    <li class="nav-item <?php if(strpos($_SERVER['PHP_SELF'], 'pages/produits/') !== false) echo 'active'; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Gestion des produits</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Produits</h6>
                <a class="collapse-item <?php if(basename($_SERVER['PHP_SELF']) == 'produits.php') echo 'active'; ?>" href="/MixMart/admin/pages/produits/produits.php">Liste des produits</a>
                <a class="collapse-item <?php if(basename($_SERVER['PHP_SELF']) == 'ajoutProduit.php') echo 'active'; ?>" href="/MixMart/admin/pages/produits/ajoutProduit.php">Ajouter un produit</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Categories -->
    <li class="nav-item <?php if(strpos($_SERVER['PHP_SELF'], 'pages/categories/') !== false) echo 'active'; ?>">
        <a class="nav-link" href="/MixMart/admin/pages/categories/categories.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Gérer les catégories</span>
        </a>
    </li>

    <!-- Nav Item - Commandes -->
    <li class="nav-item <?php if(strpos($_SERVER['PHP_SELF'], 'pages/commandes/') !== false) echo 'active'; ?>">
        <a class="nav-link" href="/MixMart/admin/pages/commandes/commandes.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Gestion des commandes</span>
        </a>
    </li>

    <!-- Nav Item - Clients -->
    <li class="nav-item <?php if(strpos($_SERVER['PHP_SELF'], 'pages/clients/') !== false) echo 'active'; ?>">
        <a class="nav-link" href="/MixMart/admin/pages/clients/clients.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Gestion des clients</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
