<?php
session_start();
header('Content-Type: application/json');

if(isset($_SESSION['name'])) {
    echo json_encode(['name' => $_SESSION['name']]);
} else {
    echo json_encode(['error' => 'Not logged in']);
}
?> 