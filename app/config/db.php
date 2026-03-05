<?php

$databases = [

    'devarenne' => [
        'host' => 'localhost',
        'db'   => 'fass',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ],

    'roger' => [
        'host' => 'localhost',
        'db'   => 'fass',
        'user' => 'root',
        'pass' => 'FOYERASSOMPTION',
        'charset' => 'utf8mb4'
    ],

    'cloud' => [
        'host' => 'mycloud.co.mg',
        'db'   => 'mycloudm_fass',
        'user' => 'mycloudm_fassuser',
        'pass' => 'FOYERASSOMPTION',
        'charset' => 'utf8mb4'
    ]

];

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = null;

foreach ($databases as $name => $config) {

    try {

        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";

        $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);

        // succès
        break;

    } catch (PDOException $e) {

        error_log("Connexion échouée ($name): " . $e->getMessage());

    }

}

if (!$pdo) {
    die("Impossible de se connecter à la base de données.");
}