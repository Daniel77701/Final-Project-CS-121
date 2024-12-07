<?php
require_once 'db_connection.php';
require_once 'store_notification.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Your existing scholarship insertion code
        $scholarshipName = $_POST['scholarship_name'] ?? '';
        
        // After successfully inserting the scholarship
        if ($success) {
            // Store the notification
            if (storeNotification($scholarshipName)) {
                error_log("Notification stored successfully for: $scholarshipName");
            } else {
                error_log("Failed to store notification for: $scholarshipName");
            }
        }
        
    } catch (Exception $e) {
        error_log("Error in add_scholarship.php: " . $e->getMessage());
    }
}
?> 