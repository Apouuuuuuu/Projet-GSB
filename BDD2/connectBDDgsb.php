<?php
define('USER', 'root');
define('PASSWD', '');
define('SERVER', '127.0.0.1');
define('BASE', 'bd_gsb');

try {
    $dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;
    $connexion = new PDO($dsn, USER, PASSWD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connexion;
} catch (PDOException $e) {
    printf("Échec de la connexion : %s\n", $e->getMessage());
    exit();
}
?>