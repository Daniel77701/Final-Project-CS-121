<?php
require_once "../connection/dbh.classes.php";

class FeaturedScholarsHandler extends Dbh {
    public function getAllScholars() {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM featured_scholars ORDER BY id DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching scholars: " . $e->getMessage());
            return [];
        }
    }

    public function addScholar($data) {
        try {
            $sql = "INSERT INTO featured_scholars (name, course, scholarship_name, message, status) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            return $stmt->execute([
                $data['name'],
                $data['course'],
                $data['scholarship_name'],
                $data['message'],
                $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Error adding scholar: " . $e->getMessage());
            return false;
        }
    }

    public function deleteScholar($id) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM featured_scholars WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting scholar: " . $e->getMessage());
            return false;
        }
    }
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $handler = new FeaturedScholarsHandler();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $scholars = $handler->getAllScholars();
        echo json_encode(['status' => 'success', 'scholar_data' => $scholars]);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add_scholar':
                $result = $handler->addScholar($_POST);
                echo json_encode([
                    'status' => $result ? 'success' : 'error',
                    'message' => $result ? 'Scholar added successfully' : 'Failed to add scholar'
                ]);
                break;

            case 'delete_scholar':
                $result = $handler->deleteScholar($_POST['scholar_id']);
                echo json_encode([
                    'status' => $result ? 'success' : 'error',
                    'message' => $result ? 'Scholar deleted successfully' : 'Failed to delete scholar'
                ]);
                break;

            default:
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid action'
                ]);
        }
        exit();
    }
}