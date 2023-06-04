<?php include 'Session/check_session.php'; 
include("traitement.php"); 

?>
<!DOCTYPE html>
<html>

<head>

    <title>GSB Covoiturage</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css.css">
    <link rel="stylesheet" type="text/css" href="checkbox.css">
    <link rel="styleshee t" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a class="nav-link" href="http://localhost/gsb/BDD2/recherche_trajet.php"><strong>Chercher un trajet</strong></a>
                <a class="nav-link" href="http://localhost/gsb/BDD2/mestrajet.php">Trajets effectués</a>
                <a class="nav-link" href="http://localhost/gsb/BDD2/mesreservations.php">Mes réservations</a>
                <a class="nav-link" href="http://localhost/gsb/BDD2/mes_avis.php">Mes avis</a>
                
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


    <?php
    function filtreRechercheActif() {
        return isset($_GET['s']) && !empty($_GET['s']);
    }

    if  (filtreRechercheActif()) {
        $recherche = htmlspecialchars($_GET['s']);
        $requete1 = $db_connexion->prepare(
            'SELECT id_trajet, 
            cout_trajet, 
            lieu_depart_trajet, 
            lieu_arrivee_trajet, 
            heure_depart_trajet,
            heure_arrivee_trajet, 
            nombre_place_trajet, 
            date_trajet
     FROM trajet
     WHERE (lieu_arrivee_trajet LIKE :recherche OR date_trajet LIKE :recherche)
           AND nombre_place_trajet > 0
           AND date_trajet >= CURDATE()
     ORDER BY id_trajet ASC');
        $requete1->bindValue(':recherche', '%' . $recherche . '%');
        $requete1->execute();
        $liste_trajet = $requete1->fetchAll(PDO::FETCH_ASSOC);
        $requete1->closeCursor();
    } else {

        $liste_trajet = $db_connexion->query('SELECT id_trajet, 
        cout_trajet, 
        lieu_depart_trajet, 
        lieu_arrivee_trajet, 
        heure_depart_trajet, 
        heure_arrivee_trajet, 
        nombre_place_trajet, 
        date_trajet 
    FROM trajet
    WHERE nombre_place_trajet > 0 AND date_trajet >= CURDATE()
    ORDER BY id_trajet ASC');
    }
    ?>
<br>
<form method="post">
    <input type="submit" class="btn btn-outline-dark" name="download" value="Télécharger le tableau">
    </form>
<?php
if (isset($_POST["download"])) {


    $dsn = "mysql:host=127.0.0.1;dbname=bd_gsb";
    $pdo = new PDO($dsn, "root", "");


    $stmt = $pdo->query("SELECT id_trajet, 
    cout_trajet, 
    lieu_depart_trajet, 
    lieu_arrivee_trajet, 
    heure_depart_trajet, 
    heure_arrivee_trajet, 
    nombre_place_trajet, 
    date_trajet 
FROM trajet
WHERE nombre_place_trajet > 0
AND date_trajet >= CURDATE()
ORDER BY id_trajet ASC
");

    $fp = fopen("Tableau_Recherche_Covoiturage.csv", "w"); // Nom + droit d'écriture (write)
    fputcsv($fp, ["ID","Prix","Lieu de depart","Lieu d'arrivee","Heure de depart","Heure d'arrivee","Nombre de places disponibles","Date du trajet"]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      fputcsv($fp, $row);
    }
    
    fclose($fp);
    $pdo = null;


header('Location: Tableau_Recherche_Covoiturage.csv');
  }
?>
    <form action="" method="GET">
        <input type="hidden" name="s" value='<?= (isset($_GET['s'])?$_GET['s']:null)?>'>
    </form>

    <div class="d-flex align-items-center justify-content-center h-75 flex-column gap-5">
        <form method="GET" class="d-flex">
            <input class="form-control me-1" type="search" style="width: 218px;" value='<?= (isset($_GET['s'])?$_GET['s']:null)?>' placeholder="Chercher une destination" name="s" aria-label="Search">
            <button class="btn btn-dark" type="submit" name="envoyer_recherche">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <table class="table table-dark table-striped">
        <!--Première ligne du tableau-->
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Lieu départ</th>
                <th scope="col">Lieu d'arrivée</th>
                <th scope="col">Date</th>
                <th scope="col">Heure de départ</th>
                <th scope="col">Heure d'arrivée</th>
                <th scope="col">Nombre de places</th>
                <th scope="col">Prix</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($liste_trajet as $trajet) { 
                ?>
                    <form action="" method="POST">
                        <tr>
                            <td scope="row"><?= $trajet["id_trajet"] ?></td>
                            <td><INPUT type="text" readonly NAME="lieu_depart_trajet" value=<?= $trajet["lieu_depart_trajet"] ?>></td>
                            <td><INPUT type="text" readonly NAME="lieu_arrivee_trajet" value=<?= $trajet["lieu_arrivee_trajet"] ?>></td>
                            <td><INPUT type="text" readonly NAME="date_trajet" value=<?= $trajet["date_trajet"] ?>></td>
                            <td><INPUT type="text" readonly NAME="heure_depart_trajet" value=<?= $trajet["heure_depart_trajet"] ?>></td>
                            <td><INPUT type="text" readonly NAME="heure_arrivee_trajet" value=<?= $trajet["heure_arrivee_trajet"] ?>></td>
                            <td><INPUT type="text" readonly NAME="nombre_place_trajet" value=<?= $trajet["nombre_place_trajet"] ?>></td>
                            <td><input type="text" readonly name="cout_trajet" value="<?= $trajet['cout_trajet'] ?>€"></td>
                            <td> <input type="submit" formaction="detail_trajet.php" value="En savoir plus"class="btn btn-outline-dark"></button></td>
                            <input type="hidden" name="id_trajet" value="<?= $trajet["id_trajet"] ?>">
                        
                        </tr>
                    </form>
            <?php
                }
            
            ?>

        </tbody>
    </table>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    
    <body>
</html>

