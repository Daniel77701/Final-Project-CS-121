<?php
require_once 'scholarship_handler.php';

if (isset($_GET['id'])) {
    $scholarship_id = $_GET['id'];
    $scholarships = new scholarship_handler();
    
    // Add this method to your scholarship_handler class
    $exists = $scholarships->checkIdExists($scholarship_id);
    
    header('Content-Type: application/json');
    echo json_encode(['exists' => $exists]);
} 