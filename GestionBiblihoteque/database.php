<?php
$dsn = 'mysql:host=localhost;dbname=bdd_bibli';
$user = 'root';
$pass = 'AECgodin.21012023';

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Définir les options PDO si nécessaire
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>