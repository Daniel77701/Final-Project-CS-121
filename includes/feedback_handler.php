<?php
require_once '../classes/dbh.classes.php';

class FeedbackHandler extends Dbh {
    public function getAllFeedbacks() {
        try {
            $sql = "SELECT scholarship, message, name, course, email, created_at 
                    FROM feedbacks 
                    ORDER BY created_at DESC";
            $conn = $this->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
}

// Create instance and get feedbacks
$handler = new FeedbackHandler();
$feedbacks = $handler->getAllFeedbacks();
?>