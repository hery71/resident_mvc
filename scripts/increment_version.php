<?php

$versionFile = __DIR__ . '/../config/version.txt';

// Lire version actuelle
$version = trim(file_get_contents($versionFile));

// Séparer major.minor
list($major, $minor) = explode('.', $version);

// Générer date heure
$datetime = date('YmdHi');

// Nouvelle version
$newVersion = "$major.$minor.$datetime";

// Sauvegarder
file_put_contents($versionFile, $newVersion);

echo "Nouvelle version : $newVersion\n";