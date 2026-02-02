<?php
require_once '../../app/core/Config.php';

$type = $_GET['type'] ?? '';
$key  = str_replace(' ', '-', $type) . '_Tasks';

$tasks = Config::inspection()[$key] ?? [];

echo json_encode($tasks);
