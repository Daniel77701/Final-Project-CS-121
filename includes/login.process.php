<?php
session_start();
require_once '../classes/LoginTracker.php';
require_once '../classes/login.classes.php';
require_once 'login.contr.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("Login process started");
    
    // Grab the data
    $sr_code = $_POST["sr_code"] ?? '';
    $pwd = $_POST["pwd"] ?? '';
    
    error_log("Attempting login for SR Code: " . $sr_code);

    try {
        // Instantiate LoginContr class
        $login = new LoginContr($sr_code, $pwd);

        // Running error handlers and user login
        $student = $login->loginUser();
        
        if ($student) {
            error_log("Login successful for student: " . $student['name']);
            // Redirect to dashboard with success message
            $_SESSION['success'] = "Login successful!";
            header("location: ../student/student-dashboard.php");
            exit();
        }
    } catch (Exception $e) {
        error_log("Login process error: " . $e->getMessage());
        $_SESSION['error'] = $e->getMessage();
        header("location: ../index.php");
        exit();
    }
} else {
    error_log("Invalid request method for login");
    header("location: ../index.php");
    exit();
} 