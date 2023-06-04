<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $pseudo = $_SESSION['pseudo']; // Récupérer le pseudo de l'utilisateur connecté
} else {
    header("Location: Session/inscription_connexion.php");
    exit();
}
?>