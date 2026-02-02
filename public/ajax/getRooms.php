<?php
require_once '../../app/core/config.php';

$aile = $_GET['aile'] ?? '';
$rooms = Config::inspection()['aileRooms'][$aile] ?? [];

echo json_encode($rooms);
