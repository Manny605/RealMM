<?php 

session_start();

if(!isset($_SESSION['ID_utilisateur'])){
    header('Location: /MixMart/auth/login.php');
}

$Nom_complet = $_SESSION['Prenom'] . ' ' . $_SESSION['Nom'];

include '../../../constants/functions.php';

$allCategories = getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/x-icon" href="/MixMart/assets/MixMart.png">


    <title>Admin : Gérer les categories</title>

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

                <div class="container-fluid">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="col">
                            <h1 class="h3 text-gray-800">Liste des categories</h1>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>

                    <?php
                    if (isset($_GET['success_ajout']) && $_GET['success_ajout'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                                    Le produit a été ajouté avec succès.
                            </div>';
                    } elseif (isset($_GET['error_ajout']) && $_GET['error_ajout'] == "upload_error") {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Erreur lors du téléchargement de l\'image';
                        echo '</div>';
                    } elseif (isset($_GET['error_ajout']) && $_GET['error_ajout'] == "missing_data") {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Erreur, des données sont manquantes';
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
                                            <th>Nom de la categorie</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php foreach($allCategories as $categorie) : ?>
                                            <tr>
                                                <td>
                                                    <img src="<?php echo $categorie['Image']; ?>" alt="" style="height: 30px; width: 30px;">    
                                                </td>
                                                <td><?php echo $categorie['Nom']; ?></td>
                                                <td class="d-flex justify-content-around">
                                                    <a href="#" class="text-info edit-btn" data-toggle="modal" data-target="#editModal<?php echo $categorie['ID_categorie']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="#" class="text-danger delete-btn" data-toggle="modal" data-target="#deleteModal<?php echo $categorie['ID_categorie']; ?>">
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




        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ajouter une rubrique</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing content -->
                        <form action="traitement_ajout.php" method="POST" id="editForm" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="content">Nom de la categorie</label>
                                <input type="text" class="form-control" id="content" name="nom_categorie" value="">
                            </div>

                            <div class="form-group">
                                    <label for="image">Image :</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" required>
                                        <label class="custom-file-label" for="image">Choisir un fichier</label>
                                    </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="Addmodal">Fermer</button>
                                <button type="submit" class="btn btn-primary" id="saveChanges">Enregistrer</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Modal -->
        <?php foreach($allCategories as $categorie) : ?>
        <div class="modal fade" id="editModal<?php echo $categorie['ID_categorie']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $categorie['ID_categorie']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier la rubrique</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing content -->
                        <form action="traitement_modifier.php" method="POST" id="editForm" enctype="multipart/form-data">
                            <input type="hidden" id="id_categorie" name="id_categorie" value="<?php echo $categorie['ID_categorie']; ?>">
                            <div class="form-group">
                                <label for="content">Nom de la categorie</label>
                                <input type="text" class="form-control" id="content" name="nom_categorie" value="<?php echo $categorie['Nom']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="image">Image :</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" onchange="updateFileName(this)">
                                    <label class="custom-file-label" id="imageLabel" for="image"><?php echo basename($categorie['Image']); ?></label>
                                    <input type="hidden" name="image_existing" value="<?php echo $categorie['Image']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="Editmodal">Fermer</button>
                                <button type="submit" class="btn btn-primary" id="saveChanges">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!--Delete Modal -->
        <?php foreach($allCategories as $categorie) : ?>
            <div class="modal fade" id="deleteModal<?php echo $categorie['ID_categorie']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $categorie['ID_categorie']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>  
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer cette categorie ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <a href="traitement_supprimer.php?id=<?php echo $categorie['ID_categorie']; ?>" class="btn btn-danger">Supprimer</a>
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
        document.getElementById('image').addEventListener('change', function() {
            var fileName = this.files[0].name;
            var label = document.querySelector('.custom-file-label');
            label.textContent = fileName;
        });
    </script>

</body>

</html>