<?php 

session_start();

if (!isset($_SESSION['ID_utilisateur'])) {
    header('Location: /MixMart/auth/login.php');
    exit();
}

require_once '../../../constants/functions.php';

$Nom_complet = $_SESSION['Prenom']. ' ' . $_SESSION['Nom'];

$allCommandes = getAllCommandesValidee();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin : Liste des commandes validees</title>

    <link rel="icon" type="image/x-icon" href="/MixMart/assets/MixMart.png">


    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


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
                        <h1 class="h3 mb-2 text-gray-800">Liste des commandes</h1>
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Liste</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php if (!empty($allCommandes)): ?>
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Produits</th>
                                                    <th>Nom du payeur</th>
                                                    <th>Numero du payeur</th>
                                                    <th>Capture d'écran</th>
                                                    <th>Date-commande</th>
                                                    <th>Etat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($allCommandes as $commande): ?>
                                                    <tr>
                                                        <td><?php echo $commande['Client'] ?></td>
                                                        <td><?php echo ($commande['nbr_produits'] > 0) ? $commande['nbr_produits'] : ''; ?></td>
                                                        <td><?php echo $commande['NomCompletPaiement'] ?></td>
                                                        <td><?php echo $commande['TelephonePaiement'] ?></td>
                                                        <td class="text-center">
                                                            <img src="../../../pages/screenshots/<?php echo $commande['ScreenshotPaiement'] ?>" alt="" style="max-width: 40px; max-height: 35px;">
                                                        </td>
                                                        <td><?php echo $commande['DateCommande'] ?></td>
                                                        <td><?php echo $commande['StatutCommande'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>Aucune donnée disponible</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->


        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../../js/demo/datatables-demo.js"></script>



</body>

</html>