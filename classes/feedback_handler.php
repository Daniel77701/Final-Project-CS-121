<?php
require_once '../connection/dbh.classes.php';

class FeedbackHandler extends Dbh {
    public function getAllFeedbacks() {
        try {
            $sql = "SELECT id, message, email, created_at 
                    FROM feedbacks 
                    ORDER BY created_at DESC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching feedbacks: " . $e->getMessage());
            return [];
        }
    }

    public function deleteFeedback($id) {
        try {
            $sql = "DELETE FROM feedbacks WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$id])) {
                throw new Exception("Failed to delete feedback");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in deleteFeedback: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    try {
        $handler = new FeedbackHandler();
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'delete_feedback':
                $id = $_POST['id'] ?? '';
                if (empty($id)) {
                    throw new Exception("ID is required");
                }
                $handler->deleteFeedback($id);
                echo json_encode(['success' => true, 'message' => 'Feedback deleted successfully']);
                break;

            default:
                throw new Exception("Invalid action");
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>