<?php 

session_start();

if(!isset($_SESSION['ID_utilisateur'])){
    header('Location: ../../../auth/login.php');
}

include '../../../constants/functions.php';

$Nom_complet = $_SESSION['Prenom'] . ' ' . $_SESSION['Nom'];

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

    <title>Admin : Ajout d'un produit</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Ajouter un nouveau produit</h1>

                    <?php

                    if (isset($_GET['error_ajout']) && $_GET['error_ajout'] == "error") {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite lors de l\'ajout.';
                        echo '</div>';
                    }
                    if (isset($_GET['error_ajout']) && $_GET['error_ajout'] == "error_upload") {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'L\'ajout de l\'image a échoué';
                        echo '</div>';
                    }
                    if (isset($_GET['error_ajout']) && $_GET['error_ajout'] == "no_image") {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'L\'image n\'a pas été téléchargée.';
                        echo '</div>';
                    }
                    if (isset($_GET['error_ajout']) && $_GET['error_ajout'] == "missing_data") {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Des données requises sont manquantes';
                        echo '</div>';
                    }

                    ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Espace d'ajout</h6>
                        </div>
                        <div class="card-body">
                            <form action="traitement_ajout.php" method="post" enctype="multipart/form-data">                                
                                <div class="form-group">
                                    <label for="nom">Nom :</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description :</label>
                                    <input type="text" class="form-control" id="description" name="description">
                                </div>
                                <div class="form-group">
                                    <label for="prix">Prix :</label>
                                    <input type="text" class="form-control" id="prix" name="prix" required>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock :</label>
                                    <input type="text" class="form-control" id="stock" name="stock" required>
                                </div>
                                <div class="form-group">
                                    <label for="categorie">Catégorie</label>
                                    <select class="form-control" id="categorie" name="categorie">
                                        <option value="" selected>Sélectionnez une catégorie</option>
                                        <?php foreach ($categories as $categorie) : ?>
                                            <option value="<?php echo $categorie['ID_categorie']; ?>">
                                                <?php echo $categorie['Nom']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image :</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" required>
                                        <label class="custom-file-label" for="image">Choisir un fichier</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
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
        document.getElementById('image').addEventListener('change', function() {
            var fileName = this.files[0].name;
            var label = document.querySelector('.custom-file-label');
            label.textContent = fileName;
        });
    </script>


</body>

</html>