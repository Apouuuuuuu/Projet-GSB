<?php
include 'Session/check_session.php';
include("traitement.php");

$pdo = new PDO('mysql:host=localhost;dbname=bd_gsb', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['pseudo'])) {
    $pseudo = $_SESSION['pseudo'];

    $reservationsQuery = "SELECT reservation.id_trajet, 
    reservation.id_reservation, 
    reservation.pseudo, 
    trajet.date_trajet, 
    trajet.id_trajet, 
    trajet.lieu_depart_trajet, 
    trajet.lieu_arrivee_trajet, 
    trajet.date_trajet,
    trajet.heure_depart_trajet,
    trajet.heure_arrivee_trajet,
    cout_trajet,
    createur_projet
    FROM reservation, trajet
    WHERE reservation.id_trajet = trajet.id_trajet
    AND reservation.pseudo = :pseudo
    AND date_trajet < CURDATE()";

    $reservationsStatement = $pdo->prepare($reservationsQuery);
    $reservationsStatement->bindParam(':pseudo', $pseudo);
    $reservationsStatement->execute();

    $reservations = $reservationsStatement->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes réservations</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css.css">
    <link rel="stylesheet" type="text/css" href="checkbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-custom justify-content-between">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/gsb/BDD2/menuprincipal.php">Menu principal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="http://localhost/gsb/BDD2/creer_trajet.php">Créer un trajet</a>
                <a class="nav-link" href="http://localhost/gsb/BDD2/recherche_trajet.php">Chercher un trajet</a>
                <a class="nav-link" href="http://localhost/gsb/BDD2/mestrajet.php"><strong>Trajets effectués</strong></a>
                <a class="nav-link" href="http://localhost/gsb/BDD2/mesreservations.php">Mes réservations</a>

                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
                    <span class="nav-link">
                        <strong>Tu es connecté en tant que</strong>
                        <strong><u><?php echo $pseudo; ?></u></strong>
                    </span>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/Session/deconnexion.php">Déconnexion</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<br>
<h2>Trajets déjà effectués</h2>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>ID Réservation</th>
            <th>Lieu de départ</th>
            <th>Lieu d'arrivée</th>
            <th>Date du trajet</th>
            <th>Heure de départ</th>
            <th>Heure d'arrivée</th>
            <th>Prix</th>
            <th></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>



      <?php
foreach ($reservations as $liste_reservation) { 
?>
    <tr>
        <td><input type="text" readonly name="id_trajet" value="<?= $liste_reservation["id_trajet"] ?>"></td>
        <td><input type="text" readonly name="lieu_depart_trajet" value="<?= $liste_reservation["lieu_depart_trajet"] ?>"></td>
        <td><input type="text" readonly name="lieu_arrivee_trajet" value="<?= $liste_reservation["lieu_arrivee_trajet"] ?>"></td>
        <td><input type="text" readonly name="date_trajet" value="<?= $liste_reservation["date_trajet"] ?>"></td>
        <td><input type="text" readonly name="heure_depart_trajet" value="<?= $liste_reservation["heure_depart_trajet"] ?>"></td>
        <td><input type="text" readonly name="heure_arrivee_trajet" value="<?= $liste_reservation["heure_arrivee_trajet"] ?>"></td>
        <td><input type="text" readonly name="cout_trajet" value="<?= $liste_reservation["cout_trajet"] ?>€"></td>
        
        <td> 
            <form action="detail_trajet.php" method="POST">
                <input type="hidden" name="id_trajet" value="<?= $liste_reservation["id_trajet"] ?>">
                <input type="hidden" name="createur_projet" value="<?= $liste_reservation["createur_projet"] ?>">
                <input type="submit" name="en_savoir_plus" value="En savoir plus" class="btn btn-outline-dark">
            </form>
        </td>
        <td>
            <form action="avis.php" method="post">
                <input type="hidden" name="id_trajet" value="<?= $liste_reservation["id_trajet"] ?>">
                <input type="hidden" name="createur_projet" value="<?= $liste_reservation["createur_projet"] ?>">
                <input type="submit" value="Soumettre un avis" class="btn btn-success">
            </form>
        </td>
    </tr>
<?php
}
?>
