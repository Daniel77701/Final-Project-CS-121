<?php
require_once 'db_connection.php';

// Function to add notification when announcement is created
function addAnnouncementNotification($subject, $announcement) {
    global $conn;
    
    try {
        // First insert the announcement
        $query = "INSERT INTO announcements (subject, announcement, date_posted) 
                 VALUES (:subject, :announcement, NOW())";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':subject' => $subject,
            ':announcement' => $announcement
        ]);
        
        return true;
    } catch (PDOException $e) {
        error_log("Error adding announcement: " . $e->getMessage());
        return false;
    }
}

// Function to add notification when scholarship is created
function addScholarshipNotification($scholarship_name, $description) {
    global $conn;
    
    try {
        // Insert the scholarship
        $query = "INSERT INTO scholarship_schema (scholarship_name, description, created_at) 
                 VALUES (:name, :description, NOW())";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':name' => $scholarship_name,
            ':description' => $description
        ]);
        
        return true;
    } catch (PDOException $e) {
        error_log("Error adding scholarship: " . $e->getMessage());
        return false;
    }
}
?> 
