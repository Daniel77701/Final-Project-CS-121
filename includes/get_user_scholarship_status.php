<?php
session_start();
require_once '../config/db_connect.php';
require_once 'scholarship_status.php';

header('Content-Type: application/json');

if (!isset($_SESSION['student_no'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$student_no = $_SESSION['student_no'];
$scholarship_status = getUserScholarshipStatus($conn, $student_no);

if ($scholarship_status) {
    echo json_encode($scholarship_status);
} else {
    echo json_encode(['error' => 'Unable to load profile']);
} 