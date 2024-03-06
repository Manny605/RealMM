<?php
session_start();

include '../constants/functions.php';

$error_message_title = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['firstname'];
    $nom = $_POST['lastname'];
    $tel = $_POST['phone'];
    $nom_user = $_POST['username'];
    $mdp = $_POST['password'];

    if(empty($prenom) || empty($nom) || empty($tel) || empty($nom_user) || empty($mdp)){
        $message_title = 'Erreur de saisie';
        $message = 'Veuillez remplir tous les champs !';
        $icon = 'warning';
    }  else {
    
        if(register($prenom, $nom, $tel, $nom_user, $mdp)) {
            $message_title = 'Inscription réussie!';
            $message = 'Vous pouvez maintenant vous connecter.';
            $icon = 'success';
        } else {
            // Alert pour une inscription échouée
            $message_title = 'Erreur!';
            $message = 'Une erreur s\'est produite lors de l\'inscription.';
            $icon = 'error';
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>S'inscrire</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



    <style>
        body {
            background-color: #f8f9fa;
        }

        .signup-form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        .signup-form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signup-form-header h2 {
            color: #ffc107;
        }

        .signup-form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .signup-form-footer a {
            color: #212529;
        }
    </style>
</head>

<body>

<?php include '../components/Navbar.php'; ?>    



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="signup-container mt-5">
                    <div class="signup-form">
                        <div class="signup-form-header">
                            <h2>S'inscrire</h2>
                        </div>
                        <form action="register.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control rounded-0 py-2" name="firstname" id="firstname" placeholder="Entrez votre prénom">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control rounded-0 py-2" name="lastname" id="lastname" placeholder="Entrez votre nom">
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control rounded-0 py-2" name="phone" id="phone" placeholder="Entrez votre numéro de téléphone">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control rounded-0 py-2" name="username" id="username" placeholder="Entrez votre nom d'utilisateur">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control rounded-0 py-2" name="password" id="password" placeholder="Entrez votre mot de passe">
                            </div>
                            <button type="submit" class="btn btn-outline-warning w-100 py-2 mt-2 rounded-0">S'inscrire</button>
                        </form>
                        <div class="signup-form-footer">
                            <p>Déjà un compte ? <a href="login.php" class="text-decoration-none text-warning">Connectez-vous</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (!empty($message_title) && !empty($message) && !empty($icon)) : ?>
        <script>
                Swal.fire({
                    title: "<?php echo $message_title; ?>",
                    text: "<?php echo $message; ?>",
                    icon: "<?php echo $icon; ?>"
                });
        </script>
    <?php endif; ?>


</body>

</html>
