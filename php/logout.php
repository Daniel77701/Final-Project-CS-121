<?php
session_start();
require_once '../classes/LoginTracker.php';

try {
    if (isset($_SESSION["user_id"])) {
        $loginTracker = new LoginTracker();
        $loginTracker->logLogout($_SESSION["user_id"]);
    }
    
    session_unset();
    session_destroy();
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Logout failed']);
}
?> 