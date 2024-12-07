<?php
session_start();
require_once '../classes/LoginTracker.php';

try {
    if (isset($_SESSION['student_id'])) {
        error_log("Starting logout process for student ID: " . $_SESSION['student_id']);
        
        // Create instance of LoginTracker
        $loginTracker = new LoginTracker();
        
        // End the login session tracking
        $success = $loginTracker->endLoginSession($_SESSION['student_id']);
        error_log("Logout tracking result: " . ($success ? 'success' : 'failed'));
        
        if (!$success) {
            error_log("Failed to record logout time");
        }
        
        // Clear all session variables
        $_SESSION = array();
        
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        // Destroy the session
        session_destroy();
    } else {
        error_log("No student_id found in session during logout");
    }
    
    // Redirect to login page
    header("Location: ../index.php");
    exit();
    
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    header("Location: ../index.php");
    exit();
} 