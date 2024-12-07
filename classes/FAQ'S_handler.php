<?php

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../connection/dbh.classes.php';

class FAQ extends Dbh {
    private $conn;

    public function __construct() {
        try {
            $this->conn = $this->connect();
            // Start transaction by default
            $this->conn->beginTransaction();
        } catch (PDOException $e) {
            error_log("Connection error: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to add FAQ
    public function addFAQ($question, $answer) {
        try {
            // Validate inputs
            if (empty($question) || empty($answer)) {
                return ['success' => false, 'message' => 'Question and answer are required'];
            }

            // Check for duplicate question
            $checkStmt = $this->conn->prepare(
                "SELECT id FROM faqs 
                 WHERE LOWER(question) = LOWER(?) 
                 AND status = 'Active'"
            );
            $checkStmt->execute([trim($question)]);
            
            if ($checkStmt->fetch()) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'This question already exists'];
            }

            // Insert new FAQ
            $stmt = $this->conn->prepare(
                "INSERT INTO faqs (question, answer, status, created_at) 
                 VALUES (?, ?, 'Active', CURRENT_TIMESTAMP)"
            );
            
            if (!$stmt->execute([trim($question), trim($answer)])) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'Failed to add FAQ'];
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'FAQ added successfully!'];
            
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Database error in addFAQ: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        }
    }

    // Method to update FAQ
    public function updateFAQ($id, $question, $answer) {
        try {
            // Validate inputs
            if (empty($id) || empty($question) || empty($answer)) {
                return ['success' => false, 'message' => 'All fields are required'];
            }

            // Check for duplicate question excluding current FAQ
            $checkStmt = $this->conn->prepare(
                "SELECT id FROM faqs 
                 WHERE LOWER(question) = LOWER(?) 
                 AND id != ? 
                 AND status = 'Active'"
            );
            $checkStmt->execute([trim($question), $id]);
            
            if ($checkStmt->fetch()) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'This question already exists'];
            }

            // Update FAQ
            $stmt = $this->conn->prepare(
                "UPDATE faqs 
                 SET question = ?, answer = ? 
                 WHERE id = ? AND status = 'Active'"
            );
            
            if (!$stmt->execute([trim($question), trim($answer), $id])) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'Failed to update FAQ'];
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'FAQ updated successfully!'];
            
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Database error in updateFAQ: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        }
    }

    // Method to delete FAQ (soft delete)
    public function deleteFAQ($id) {
        try {
            if (empty($id)) {
                return ['success' => false, 'message' => 'Invalid FAQ ID'];
            }

            $stmt = $this->conn->prepare(
                "UPDATE faqs 
                 SET status = 'Inactive' 
                 WHERE id = ? AND status = 'Active'"
            );
            
            if (!$stmt->execute([$id])) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'Failed to delete FAQ'];
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'FAQ deleted successfully!'];
            
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Database error in deleteFAQ: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        }
    }

    // Method to fetch all active FAQs
    public function getFAQs() {
        try {
            $stmt = $this->conn->prepare(
                "SELECT id, question, answer, created_at 
                 FROM faqs 
                 WHERE status = 'Active' 
                 ORDER BY created_at DESC"
            );
            $stmt->execute();
            $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format each FAQ with HTML structure
            foreach ($faqs as &$faq) {
                $faq['formatted_answer'] = '<div class="faq-answer" style="margin-left: 10px; padding: 8px; border-left: 2px solid #ddd;">' . 
                                         htmlspecialchars($faq['answer']) . 
                                         '</div>';
            }
            
            return $faqs;
        } catch (PDOException $e) {
            error_log("Error fetching FAQs: " . $e->getMessage());
            return [];
        }
    }

    // Destructor to ensure clean transaction handling
    public function __destruct() {
        try {
            if ($this->conn && $this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
        } catch (PDOException $e) {
            error_log("Error in destructor: " . $e->getMessage());
        }
    }
}

?>
