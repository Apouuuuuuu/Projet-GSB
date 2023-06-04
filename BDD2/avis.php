<?php
include 'Session/check_session.php';
include_once 'connectBDDgsb.php';

$pdo = new PDO('mysql:host=localhost;dbname=bd_gsb', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_trajet = $_POST['id_trajet'];
$createur_projet = $_POST['createur_projet'];
$membreDonneAvis = $_SESSION['pseudo']; // Récupérer le pseudo de l'utilisateur connecté

if (isset($_POST['donner_avis'])) {
    $commentaireAvis = $_POST['commentaire_avis'];
    $noteAvis = $_POST['note_avis'];

    try {
        $sql = 'INSERT INTO avis (id_trajet, createur_projet, commentaire_avis, note_avis, membre_donne_avis) VALUES (:id_trajet, :createur_projet, :commentaireAvis, :noteAvis, :membreDonneAvis)';
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_trajet', $id_trajet);
        $stmt->bindParam(':createur_projet', $createur_projet);
        $stmt->bindParam(':commentaireAvis', $commentaireAvis);
        $stmt->bindParam(':noteAvis', $noteAvis);
        $stmt->bindParam(':membreDonneAvis', $membreDonneAvis);

        $stmt->execute();

        echo '<script>alert("Votre avis a bien été pris en compte : ' . $commentaireAvis . '\nNote : ' . $noteAvis . '/10 \nConducteur : ' . $createur_projet . '");</script>';
    } catch (PDOException $e) {
        echo "Une erreur s'est produite lors de l'ajout de l'avis : " . $e->getMessage();
    }
    ?><br>
    <?php
    var_dump($_POST, $pseudo);
    die();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
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
                    <a class="nav-link" href="http://localhost/gsb/BDD2/mestrajet.php">Mes trajets</a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/mesreservations.php">Mes réservations</a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/mes_avis.php">Mes Avis</a>

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

    <br>
    <p><strong>Donnez votre avis sur votre trajet !</strong></p><br>

    <form action="avis.php" method="post">
        Avis : <textarea name="commentaire_avis" rows="4" cols="40"
            placeholder="Un avis sur le trajet, le conducteur, le respect des horaires.."></textarea><br>
        Note sur 10 : <input type="number" name="note_avis" min="0" max="10" step="0.1" required>
        <br><br>
        <input type="hidden" name="createur_projet" value="<?php echo $createur_projet; ?>">
        <input type="hidden" name="id_trajet" value="<?php echo $id_trajet; ?>">
        <input type="submit" name="donner_avis" class="btn btn-success" value="Soumettre mon avis">
    </form>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>