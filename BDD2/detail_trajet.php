<?php
include 'Session/check_session.php';
include("traitement.php");
$pdo = new PDO('mysql:host=localhost;dbname=bd_gsb', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['reserve_button'])) {
    if (isset($_POST['id_trajet'])) {
        $id_trajet = $_POST['id_trajet'];
        $createur_projet = $_SESSION['pseudo'];

        // Ajoute la réservation dans la table
        $reservationQuery = "INSERT INTO reservation (id_trajet, pseudo) VALUES (:id_trajet, :pseudo)";
        $reservationStatement = $pdo->prepare($reservationQuery);
        $reservationStatement->bindParam(':id_trajet', $id_trajet);
        $reservationStatement->bindParam(':pseudo', $createur_projet);
        $reservationStatement->execute();

        // Soustrait nb place dispo
        $updateQuery = "UPDATE trajet SET nombre_place_trajet = nombre_place_trajet - 1 WHERE id_trajet = :id_trajet";
        $updateStatement = $pdo->prepare($updateQuery);
        $updateStatement->bindParam(':id_trajet', $id_trajet);
        $updateStatement->execute();

        echo '<script>alert("Trajet réservé avec succès"); window.location.href = "mesreservations.php";</script>';
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>GSB Covoiturage</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css.css">
    <link rel="stylesheet" type="text/css" href="checkbox.css">
    <link rel="styleshee t" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<nav class="navbar navbar-expand-lg bg-dark navbar-custom justify-content-between">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/gsb/BDD2/menuprincipal.php">Menu principal</a>
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
                                <?php echo $_SESSION['pseudo']; ?>
                            </u></strong>
                    </span>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/Session/deconnexion.php">Déconnexion</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
<br>
<?php
$id_trajet = $_POST['id_trajet'];
$pdo = new PDO('mysql:host=localhost;dbname=bd_gsb', 'root', '');
$stmt = $pdo->prepare("SELECT id_trajet, lieu_depart_trajet, lieu_arrivee_trajet, date_trajet, nombre_place_trajet, heure_depart_trajet, heure_arrivee_trajet, type_voiture_trajet, modele_voiture_trajet, commentaire_trajet, cout_trajet, createur_projet FROM trajet WHERE id_trajet = :id_trajet");
$stmt->execute(array(':id_trajet' => $id_trajet));

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
    <strong>Voici les informations concernant le trajet #
        <?php echo $row['id_trajet'] ?> de
        <?php echo $row['createur_projet'] ?>
    </strong><br><br>

    Lieu de départ <input readonly type="text" value="<?php echo $row['lieu_depart_trajet']; ?>"><br>
    Lieu d'arrivée <input readonly type="text" value="<?php echo $row['lieu_arrivee_trajet']; ?>"><br>
    Date <input readonly type="date" value="<?php echo $row['date_trajet']; ?>"><br>
    Nombre de place disponibles <input readonly type="text" value="<?php echo $row['nombre_place_trajet']; ?>"> <br>
    Heure de départ <input readonly type="text" value="<?php echo $row['heure_depart_trajet']; ?>"> <br>
    Heure d'arrivée <input readonly type="text" value="<?php echo $row['heure_arrivee_trajet']; ?>"><br>
    Type de voiture <input readonly type="text" value="<?php echo $row['type_voiture_trajet']; ?>"> <br>
    Modèle de voiture <input readonly type="text" value="<?php echo $row['modele_voiture_trajet']; ?>"><br>
    Prix <input readonly type="text" value="<?php echo $row['cout_trajet']; ?>€"><br>
    Commentaire <textarea readonly rows="2" cols="20"><?php echo $row['commentaire_trajet']; ?></textarea><br>
<?php } ?>
<form method="post" action="detail_trajet.php">
    <input type="hidden" name="id_trajet" value="<?php echo $id_trajet; ?>">
    <button type="submit" class="btn btn-success" name="reserve_button">Je réserve le trajet !</button>
</form>
<script type="text/javascript" src="../bootstrap.min.js"></script>
</body>

</html>