<?php

$options = require '../../app/config/options.php';

$service = $_GET['service'] ?? '';

$departements = $options['Departement'][$service] ?? [];

header('Content-Type: application/json');

echo json_encode($departements);