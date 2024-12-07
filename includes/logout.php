<?php
session_start();
require_once '../classes/LoginTracker.php';

if (isset($_SESSION['student_id'])) {
    $loginTracker = new LoginTracker();
    
    error_log("Logout initiated for student ID: " . $_SESSION['student_id']);
    
    try {
        if (!$loginTracker->endLoginSession($_SESSION['student_id'])) {
            error_log("Failed to end login session for student ID: " . $_SESSION['student_id']);
        }
    } catch (Exception $e) {
        error_log("Error during logout: " . $e->getMessage());
    }
}

// Clear all session variables
session_unset();
session_destroy();

// Redirect to login page
header("Location: ../index.php");
exit();
?> 