<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../classes/scholars_handler.php';
$scholars = new ScholarsHandler();

header('Content-Type: application/json');

try {
    $scholarships = $scholars->getAvailableScholarships();
    error_log("Sending scholarships: " . print_r($scholarships, true));
    
    if (empty($scholarships)) {
        error_log("No active scholarships found");
    }
    
    echo json_encode($scholarships);
} catch (Exception $e) {
    error_log("Error in getScholarships.php: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch scholarships']);
} 