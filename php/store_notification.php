<?php
require_once 'db_connection.php';

function storeNotification($scholarshipName) {
    global $conn;
    
    try {
        // Insert notification
        $query = "
            INSERT INTO notifications (
                title,
                message,
                type,
                link,
                timestamp,
                status,
                is_read
            ) VALUES (
                :title,
                :message,
                'scholarship',
                '../php/user_schema.php',
                NOW(),
                'active',
                0
            )";

        $stmt = $conn->prepare($query);
        
        // Execute with parameters
        $success = $stmt->execute([
            ':title' => $scholarshipName,
            ':message' => "New scholarship $scholarshipName is now available!"
        ]);

        if (!$success) {
            error_log("Failed to insert notification for scholarship: $scholarshipName");
            return false;
        }

        error_log("Successfully stored notification for scholarship: $scholarshipName");
        return true;

    } catch (Exception $e) {
        error_log("Error storing notification: " . $e->getMessage());
        return false;
    }
}

// Test function to manually add a notification
function addTestNotification() {
    try {
        storeNotification("Test Scholarship");
        return true;
    } catch (Exception $e) {
        error_log("Error adding test notification: " . $e->getMessage());
        return false;
    }
}

// Add a test notification if called directly
if (php_sapi_name() === 'cli' || isset($_GET['test'])) {
    addTestNotification();
}
?> 