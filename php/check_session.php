<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['student_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Not logged in',
        'redirect' => 'user_login.html'
    ]);
    exit;
}

echo json_encode([
    'status' => 'success',
    'data' => [
        'id' => $_SESSION['student_id'],
        'name' => $_SESSION['student_name']
    ]
]); 