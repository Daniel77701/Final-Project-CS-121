<?php
require_once 'database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    echo "Database connected successfully!";
} catch(Exception $e) {
    echo "Connection failed: " . $e->getMessage();
} 