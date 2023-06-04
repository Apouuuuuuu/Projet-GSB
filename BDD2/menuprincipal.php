<?php include 'Session/check_session.php';

include("traitement.php");


?>
<!DOCTYPE html>
<html>

<head>

    <title>Talbeau des sorties de parc</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css.css">
    <link rel="stylesheet" type="text/css" href="checkbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>




<body>


    <nav class="navbar navbar-expand-lg bg-dark navbar-custom justify-content-between">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/gsb/BDD2/menuprincipal.php"><strong>Menu
                    principal</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="http://localhost/gsb/BDD2/creer_trajet.php">Créer un trajet</a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/recherche_trajet.php">Chercher un trajet</a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/mestrajet.php">Trajets effectués</a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/mesreservations.php">Mes réservations</a>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
                        <span class="nav-link">
                            <strong>Tu es connecté en tant que</strong>
                            <strong><u>
                                    <?php echo $pseudo; ?>
                                </u></strong>
                        </span>
                        <a class="nav-link" href="http://localhost/gsb/BDD2/Session/deconnexion.php">Déconnexion</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>





    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <body>

</html>


