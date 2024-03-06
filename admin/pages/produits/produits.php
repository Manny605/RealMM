<?php 

session_start();

if(!isset($_SESSION['ID_utilisateur'])){
    header('Location: ../../../auth/login.php');
}

$Nom_complet = $_SESSION['Prenom'] . ' ' . $_SESSION['Nom'];

include '../../../constants/functions.php';

$allProducts = GetAllProducts();
$categories = getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin : Les produits</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include '../../../components/Sidebar.php'; ?>
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include '../../../components/Topbar.php'; ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Liste des produits</h1>

                    <?php
                    if (isset($_GET['success_ajout']) && $_GET['success_ajout'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                                    Le produit a été ajouté avec succès.
                            </div>';
                    } elseif (isset($_GET['error_ajout'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }

                    if (isset($_GET['success_modif']) && $_GET['success_modif'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                                    Le produit a été mis à jour avec succès.
                            </div>';
                    } elseif (isset($_GET['error_modif'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }

                    if (isset($_GET['success_supp']) && $_GET['success_supp'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                                    Le produit a été supprimé avec succès.
                            </div>';
                    } elseif (isset($_GET['error_supp'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }
                    ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nom</th>
                                            <th>Description</th>
                                            <th>Prix</th>
                                            <th>Stock Disponible</th>
                                            <th>Categorie</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php foreach($allProducts as $product) : ?>
                                            <tr>
                                                <td>
                                                    <img src="<?php echo $product['Image']; ?>" alt="" style="height: 30px; width: 40px;">
                                                </td>
                                                <td><?php echo $product['Nom']; ?></td>
                                                <td>
                                                    <?php 
                                                        if (!empty($product['Description'])) {
                                                            echo substr($product['Description'], 0, 60);
                                                        } else {
                                                            echo "Aucune description disponible";
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $product['Prix']; ?> MRU</td>
                                                <td><?php echo $product['Stock']; ?></td>
                                                <td><?php echo $product['Nom_categorie']; ?></td>
                                                <td class="d-flex justify-content-around">
                                                    <a href="#" class="text-info edit-btn" data-toggle="modal" data-target="#editModal<?php echo $product['ID_produit']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="text-danger delete-btn" data-toggle="modal" data-target="#deleteModal<?php echo $product['ID_produit']; ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Edit Modal -->
    <?php foreach($allProducts as $product) : ?>
    <div class="modal fade" id="editModal<?php echo $product['ID_produit']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $product['ID_produit']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier le produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing content -->
                    <form action="traitement_modifier.php" method="POST" id="editForm" enctype="multipart/form-data">
                        <input type="hidden" id="id_produit" name="id_produit" value="<?php echo $product['ID_produit']; ?>">
                        <div class="form-group">
                            <label for="content">Nom</label>
                            <input type="text" class="form-control" id="content" name="nom" value="<?php echo $product['Nom']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="content">Description</label>
                            <input type="text" class="form-control" id="content" name="description" value="<?php echo $product['Description']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="content">Prix</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="content" name="prix" value="<?php echo $product['Prix']; ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">MRU</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">Stock</label>
                            <input type="text" class="form-control" id="content" name="stock" value="<?php echo $product['Stock']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="categorie">Catégorie</label>
                            <select class="form-control" id="categorie" name="categorie">
                                <?php foreach ($categories as $categorie) : ?>
                                    <option value="<?php echo $categorie['ID_categorie']; ?>" <?php echo ($categorie['ID_categorie'] == $product['categorie_id']) ? 'selected' : ''; ?>>
                                        <?php echo $categorie['Nom']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Image :</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" onchange="updateFileName(this)">
                                <label class="custom-file-label" id="imageLabel" for="image"><?php echo basename($product['Image']); ?></label>
                                <input type="hidden" name="image_existing" value="<?php echo $product['Image']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" id="saveChanges">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!--Delete Modal -->
    <?php foreach($allProducts as $product) : ?>
        <div class="modal fade" id="deleteModal<?php echo $product['ID_produit']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $product['ID_produit']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer ce produit ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <a href="traitement_supprimer.php?id=<?php echo $product['ID_produit']; ?>" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/datatables-demo.js"></script>


    <script>
        function updateFileName(input) {
            var fileName = input.files[0].name;
            document.getElementById("imageLabel").innerText = fileName;
        }
    </script>

</body>

</html>