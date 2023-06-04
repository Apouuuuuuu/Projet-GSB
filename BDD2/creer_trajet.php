<?php include 'Session/check_session.php';


include_once 'connectBDDgsb.php';

if (isset($_POST['creer_trajet'])) {
    // Récupérer les valeurs du formulaire
    $lieuDepart = $_POST['lieu_depart_trajet'];
    $lieuArrivee = $_POST['lieu_arrivee_trajet'];
    $heureDepart = $_POST['heure_depart_trajet'];
    $heureArrivee = $_POST['heure_arrivee_trajet'];
    $dateTrajet = $_POST['date_trajet'];
    $typeVoiture = $_POST['type_voiture_trajet'];
    $modeleVoiture = $_POST['modele_voiture_trajet'];
    $placesDispo = $_POST['nombre_place_trajet'];
    $prix = $_POST['cout_trajet'];
    $com_trajet = $_POST['commentaire_trajet'];
    $createurProjet = $_POST['createur_projet'];


    try {
        $sql = 'INSERT INTO trajet (lieu_depart_trajet, lieu_arrivee_trajet, heure_depart_trajet, heure_arrivee_trajet, date_trajet, nombre_place_trajet, cout_trajet, commentaire_trajet, type_voiture_trajet, modele_voiture_trajet, createur_projet) VALUES (:lieuDepart, :lieuArrivee, :heureDepart, :heureArrivee, :dateTrajet, :placesDispo, :prix, :com_trajet, :typeVoiture, :modeleVoiture, :createurProjet)';

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':lieuDepart', $lieuDepart);
        $stmt->bindParam(':lieuArrivee', $lieuArrivee);
        $stmt->bindParam(':heureDepart', $heureDepart);
        $stmt->bindParam(':heureArrivee', $heureArrivee);
        $stmt->bindParam(':dateTrajet', $dateTrajet);
        $stmt->bindParam(':typeVoiture', $typeVoiture);
        $stmt->bindParam(':modeleVoiture', $modeleVoiture);
        $stmt->bindParam(':placesDispo', $placesDispo);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':com_trajet', $com_trajet);
        $stmt->bindParam(':createurProjet', $createurProjet);
        $stmt->execute();

        echo '<script>alert("Le trajet a bien été créé. \nLieu de départ : ' . $lieuDepart . ' \nLieu d\'arrivée : ' . $lieuArrivee . ' \nHeure de départ : ' . $heureDepart . ' \nHeure d\'arrivée : ' . $heureArrivee . ' \nDate : ' . $dateTrajet . ' \nType de voiture : ' . $typeVoiture . ' \nModèle de voiture : ' . $modeleVoiture . ' \nNombre de places disponibles : ' . $placesDispo . ' \nPrix : ' . $prix . ' \nCommentaire : ' . $com_trajet . ' \nCréateur du trajet : ' . $createurProjet . '");</script>';
    } catch (PDOException $e) {
        echo "Une erreur s'est produite lors de la création du trajet : " . $e->getMessage();
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
                    <a class="nav-link" href="http://localhost/gsb/BDD2/creer_trajet.php"><strong>Créer un
                            trajet</strong></a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/recherche_trajet.php">Chercher un trajet</a>
                    <a class="nav-link" href="http://localhost/gsb/BDD2/mestrajet.php">Mes trajets</a>
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



    <br>
    <p><strong>Créez votre trajet en fournissant toutes les informations nécessaires.</strong></p><br>

    <form action="creer_trajet.php" method="post">
        Lieu Départ Trajet: <input type="text" name="lieu_depart_trajet"><br>
        Lieu Arrivée Trajet: <input type="text" name="lieu_arrivee_trajet"><br>
        Heure Départ Trajet:
        <select name="heure_depart_trajet">
            <?php
            for ($hour = 0; $hour <= 23; $hour++) {
                for ($minute = 0; $minute <= 30; $minute += 30) {
                    $time = sprintf("%02dh%02d", $hour, $minute);
                    echo "<option value=\"$time\">$time</option>";
                }
            }
            ?>
        </select><br>
        Heure Arrivée Trajet:
        <select name="heure_arrivee_trajet">
            <?php
            for ($hour = 0; $hour <= 23; $hour++) {
                for ($minute = 0; $minute <= 30; $minute += 30) {
                    $time = sprintf("%02dh%02d", $hour, $minute);
                    echo "<option value=\"$time\">$time</option>";
                }
            }
            ?>
        </select><br>
        Date Trajet: <input type="date" name="date_trajet"><br>
        Nombre de places disponibles: <input type="number" name="nombre_place_trajet"><br>
        Prix par personne: <input type="number" name="cout_trajet"><br>
        Commentaire : <textarea name="commentaire_trajet"></textarea><br>
        Type Voiture Trajet: <select name="type_voiture_trajet">
            <option value="Personnelle">Personnelle</option>
            <option value="Professionnelle">Professionnelle</option>
        </select><br>
        Modèle Voiture Trajet: <select name="modele_voiture_trajet">
            <option value="Supra Toyota">Supra Toyota</option>
            <option value="Charger dodge">Charger dodge</option>
            <option value="GTR Nissan">GTR Nissan</option>
            <option value="Alfa romeo Giulia">Alfa romeo Giulia</option>
            <option value="Peugeot 308">Peugeot 308</option>
            <option value="Peugeot 4008">Peugeot 4008</option>
            <option value="Citroen 307+">Citroen 307+</option>
            <option value="Citroen DS4">Citroen DS 4</option>
        </select><br>
        <input type="hidden" name="createur_projet" value="<?php echo $pseudo; ?>">
        <input type="submit" name="creer_trajet" class="btn btn-outline-success" value="Créer le trajet">




    </form>


    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>