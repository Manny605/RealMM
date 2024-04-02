<?php 

session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: /MixMart/auth/login.php');
    exit();
}

$Nom_complet = $_SESSION['Prenom']. ' ' . $_SESSION['Nom'];

require_once '../../../constants/functions.php';

$allClients = getAllClients();

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

    <title>Admin : Gestion des clients</title>

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
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-between mb-4">
                            <div class="col">
                                <h1 class="h3 text-gray-800">Liste des clients</h1>
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
                                    La creation du compte a été Validée avec succès.
                            </div>';
                    } elseif (isset($_GET['error_ajout'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }

                    if (isset($_GET['success_modif']) && $_GET['success_modif'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                                    Le compte du client a été mis à jour avec succès.
                            </div>';
                    } elseif (isset($_GET['error_modif'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Une erreur inconnue s\'est produite.';
                        echo '</div>';
                    }

                    if (isset($_GET['success_supp']) && $_GET['success_supp'] == "ok") {
                        echo '<div class="alert alert-success" role="alert">
                                    Le compte du client a été supprimé avec succès.
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
                                            <th>Prenom</th>
                                            <th>Nom</th>
                                            <th>Identifiant</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach($allClients as $client) : 
                                        ?>

                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $client['Prenom'] ?></td>
                                            <td><?php echo $client['Nom'] ?></td>
                                            <td><?php echo $client['Nom_utilisateur'] ?></td>
                                            <td class="d-flex justify-content-around">
                                                <a href="#" class="text-info edit-btn" data-toggle="modal" data-target="#editModal<?php echo $client['ID_utilisateur']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="#" class="text-danger delete-btn" data-toggle="modal" data-target="#deleteModal<?php echo $client['ID_utilisateur']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                        $i++; // Increment the counter
                                        endforeach; 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    </div>


            </div>
            <!-- End of Main Content -->

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ajouter un client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing content -->
                        <form action="traitement_ajout.php" method="POST" id="editForm">

                            <div class="form-group">
                                <label for="content">Prenom</label>
                                <input type="text" class="form-control" id="content" name="prenom" value="">
                            </div>
                            <div class="form-group">
                                <label for="content">Nom</label>
                                <input type="text" class="form-control" id="content" name="nom" value="">
                            </div>
                            <div class="form-group">
                                <label for="content">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="content" name="nom_utilisateur" value="">
                            </div>
                            <div class="form-group">
                                <label for="content">Telephone</label>
                                <input type="text" class="form-control" id="content" name="phone" value="">
                            </div>
                            <div class="form-group">
                                <label for="content">Mot de passe</label>
                                <input type="text" class="form-control" id="content" name="mdp" value="">
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
        <?php foreach($allClients as $client) : ?>
        <div class="modal fade" id="editModal<?php echo $client['ID_utilisateur']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $client['ID_utilisateur']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier le client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing content -->
                        <form action="traitement_modifier.php" method="POST" id="editForm">
                            
                            <input type="hidden" id="id_utilisateur" name="id_utilisateur" value="<?php echo $client['ID_utilisateur']; ?>">
                            
                            <div class="form-group">
                                <label for="content">Prenom</label>
                                <input type="text" class="form-control" id="content" name="prenom" value="<?php echo $client['Prenom']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="content">Nom</label>
                                <input type="text" class="form-control" id="content" name="nom" value="<?php echo $client['Nom']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="content">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="content" name="nom_utilisateur" value="<?php echo $client['Nom_utilisateur']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="content">Telephone</label>
                                <input type="text" class="form-control" id="content" name="phone" value="<?php echo $client['Phone']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="content">Mot de passe</label>
                                <input type="text" class="form-control" id="content" name="mdp" value="<?php echo $client['MotDePasse']; ?>">
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
        <?php foreach($allClients as $client) : ?>
            <div class="modal fade" id="deleteModal<?php echo $client['ID_utilisateur']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $client['ID_utilisateur']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>                        
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer ce client ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <a href="traitement_supprimer.php?id=<?php echo $client['ID_utilisateur']; ?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

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

</body>

</html>