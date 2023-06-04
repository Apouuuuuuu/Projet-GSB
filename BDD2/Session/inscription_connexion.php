<?php
define('USER', 'root');
define('PASSWD', '');
define('SERVER', '127.0.0.1');
define('BASE', 'bd_gsb');

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . SERVER . ";dbname=" . BASE, USER, PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Fonction de hachage du mot de passe
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Vérification du mot de passe haché
function verifyPassword($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}

// Inscription de l'utilisateur
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $pseudo = $_POST['pseudo'];
    $phone = $_POST['phone'];

    // Vérification si le mot de passe satisfait les critères
    if (
        strlen($password) < 12 || // Au moins 12 caractères
        !preg_match("/[A-Z]/", $password) || // Au moins une majuscule
        !preg_match("/[a-z]/", $password) || // Au moins une minuscule
        !preg_match("/[0-9]/", $password) || // Au moins un chiffre
        !preg_match("/[^A-Za-z0-9]/", $password) // Au moins un caractère spécial
    ) {
        echo '<script>alert("Le mot de passe doit contenir au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial");</script>';
    } elseif ($password !== $confirmPassword) {
        echo '<script>alert("Les mots de passe ne correspondent pas");</script>';
    } else {
        // Vérification si l'adresse email ou le pseudo existe déjà dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR pseudo = :pseudo");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo '<script>alert("L\'adresse mail ou le pseudo sont déjà utilisés");</script>';
        } else {
            // Insertion du nouvel utilisateur dans la base de données
            $hashedPassword = hashPassword($password);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, pseudo, phone) VALUES (:email, :password, :pseudo, :phone)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':phone', $phone);

            if ($stmt->execute()) {
                echo '<script>alert("Inscription réussie");</script>';
            } else {
                echo '<script>alert("Erreur lors de l\'inscription");</script>';
            }
        }
    }
}

// Connexion de l'utilisateur
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT password, pseudo FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $hashedPassword = $row['password'];

        // Vérification du mot de passe
        if (verifyPassword($password, $hashedPassword)) {
            // Connexion réussie, définit var de session
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['pseudo'] = $row['pseudo'];

            header("Location: ../menuprincipal.php");
            exit();
        } else {
            echo '<script>alert("Mauvais mot de passe");</script>';
        }
    } else {
        echo '<script>alert("Adresse mail introuvable");</script>';
    }
}
?>



<!DOCTYPE html>
<html>

<head>


    <title>GSB Inscription/Connexion</title>

    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css.css">
    <link rel="stylesheet" type="text/css" href="../checkbox.css">
    <link rel="styleshee t" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Inscription et Connexion</title>

    <nav class="navbar navbar-expand-lg bg-dark navbar-custom justify-content-between">
        <div class="container-fluid">
            <a class="navbar-brand"
                href="http://localhost/gsb/BDD2/Session/inscription_connexion.php">Inscription/Connexion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            </div>
        </div>
    </nav>

</head>

<body>
    <h1>Inscription</h1>
    <form method="POST" action="">
        <label for="email">Adresse email :</label>
        <input type="email" name="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" required><br>

        <label for="phone">Numéro de téléphone :</label>
        <input type="number" name="phone" required><br>

        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" required><br>

        <input type="submit" class="btn btn-outline-dark" name="register" value="S'inscrire">
    </form><br>

    <h1>Connexion</h1>
    <form method="POST" action="">
        <label for="email">Adresse email :</label>
        <input type="email" name="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <input type="submit" class="btn btn-outline-dark" name="login" value="Se connecter">
    </form>



    <script src="../../js/bootstrap.bundle.min.js"></script>

</body>

</html>