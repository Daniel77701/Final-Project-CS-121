<?php
require_once '../classes/scholarship_handler.php';

if (isset($_GET['id'])) {
    try {
        $scholarships = new ScholarshipHandler();
        $exists = $scholarships->checkScholarshipExists($_GET['id']);
        
        header('Content-Type: application/json');
        echo json_encode(['exists' => $exists]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server error occurred']);
    }
} else {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['error' => 'No ID provided']);
} 