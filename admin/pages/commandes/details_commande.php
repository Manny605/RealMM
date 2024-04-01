<?php 

session_start();

if(!isset($_SESSION['ID_utilisateur'])){
    header('Location: /MixMart/auth/login.php');
}

include '../../../constants/functions.php';

$Nom_complet = $_SESSION['Prenom'] . ' ' . $_SESSION['Nom'];

$commande_id = $_GET['idd'];

$details = getDetailsCommande($commande_id);

$paiement = DetailsPaiement($commande_id);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Commande &#8470 <?php echo $commande_id ?></title>

    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        body{
            background:#eee;
        }
        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: 1rem;
        }
        .text-reset {
            --bs-text-opacity: 1;
            color: inherit!important;
        }
        a {
            color: #5465ff;
            text-decoration: none;
        }
    </style>


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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">La commande &#8470 <?php echo $commande_id ?> </h6>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-12 col-sm-12 p-4">
                                <!-- Details -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="mb-3 d-flex justify-content-between">
                                            <div>
                                                <span class="me-3"><?php echo $paiement['DateCommande']; ?></span>
                                            </div>
                                        </div>
                                    <table class="table table-borderless">
                                        <tbody>

                                        <?php 
                                        $total = 0;
                                        foreach($details as $product) : 
                                            $subtotal = $product['Quantite'] * $product['PrixUnitaire'];
                                            $total += $subtotal;
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex mb-2">
                                                        <div class="flex-shrink-0">
                                                            <img src="../produits/<?php echo $product['Image'] ;?>" alt="" width="35" class="img-fluid">
                                                        </div>
                                                        <div class="d-flex flex-column ms-4">
                                                            <h6 class="small mb-0"><a href="#" class="text-reset"><?php echo $product['Nom'] ?></a></h6>
                                                            <span class="small text-warning"><?php echo $product['Nom_categorie'] ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $product['Quantite'] ?></td>
                                                <td class="text-end"><?php echo $product['PrixUnitaire']; ?> MRU</td>
                                            </tr>
                                        <?php endforeach; ?>


                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2">Subtotal</td>
                                            <td class="text-end"><?php echo $total; ?> MRU</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Livraison</td>
                                            <td class="text-end">00.00 MRU</td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td colspan="2">TOTAL</td>
                                            <td class="text-end"><?php echo $total; ?> MRU</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    </div>
                                </div>

                                <!-- Payment -->
                                <div class="row">

                                    <div class="col-lg-8">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h3 class="h6">Paiement</h3>
                                                <p>Nom du payeur: <?php echo $paiement['NomCompletPaiement']; ?></br>
                                                Telephone du payeur: <?php echo $paiement['TelephonePaiement']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="card mb-4">
                                            <div class="card-body text-center">
                                                    <a href="#" onClick="ShowImage()">
                                                        <img src="../../../pages/screenshots/<?php echo $paiement['ScreenshotPaiement']; ?>" alt="" style="max-height:200px; max-width:60px;">
                                                    </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <a href="valide_commande.php" class="btn btn-success w-100 rounded-0">Valider la commande</a>

                            </div>

                            
                        </div>
                    </div>

                    


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script>
        function ShowImage(){
            Swal.fire({
                imageUrl: "../../../pages/screenshots/<?php echo $paiement['ScreenshotPaiement']; ?>",
                imageHeight: 400,
                imageAlt: "A tall image"
            });
        }
    </script>

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