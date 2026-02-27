<?php
/**
 * =========================================================
 * Configuration de la connexion à la base de données
 * Projet : resident_mvc
 * =========================================================
 */

// ---------------------------------------------------------
// Paramètres de connexion
// ---------------------------------------------------------
//CLOUD DB
$host = 'mycloud.co.mg';
$db   = 'mycloudm_fass';
$user = 'mycloudm_fassuser';
$pass = 'FOYERASSOMPTION';
$charset = 'utf8mb4';

//LOCAL DB devarenne
$host = 'localhost';
$db   = 'fass';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

//LOCAL DB ROGER
$host = 'localhost';
$db   = 'fass';
$user = 'root';
$pass = 'FOYERASSOMPTION';
$charset = 'utf8mb4';
// ---------------------------------------------------------
// DSN PDO
// ---------------------------------------------------------
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// ---------------------------------------------------------
// Options PDO sécurisées
// ---------------------------------------------------------
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
];

// ---------------------------------------------------------
// Connexion PDO
// ---------------------------------------------------------
try {

    $pdo = new PDO($dsn, $user, $pass, $options);

    // 🔥 Rendre PDO accessible globalement (MVC + ancien code)
    $GLOBALS['pdo'] = $pdo;

    // -----------------------------------------------------
    // Chargement des infos globales (organisation)
    // -----------------------------------------------------
    $stmt = $pdo->query("SELECT nom FROM organisation LIMIT 1");
    $row = $stmt->fetch();

    $organisation_name = $row ? $row['nom'] : '';

    // 🔥 Rendre le nom de l'organisation global
    $GLOBALS['organisation_name'] = $organisation_name;

} catch (PDOException $e) {

    // En PROD, tu peux remplacer par un log fichier
    die(
        "❌ Erreur de connexion à la base de données :<br>" .
        htmlspecialchars($e->getMessage())
    );
}
