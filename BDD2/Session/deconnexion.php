<?php
session_start();

// Enlève la var de session
$_SESSION = array();

// Détruit la session
session_destroy();

// Redirection vers la page d'inscription/cconnexion
header("Location: inscription_connexion.php");
exit();
?>