<?php
require_once "../connection/dbh.classes.php";

class FeaturedScholarsHandler extends Dbh {
    // Get list of all scholars for dropdown
    public function getScholarsList() {
        try {
            $sql = "SELECT sr_code, name, course, scholarship 
                   FROM scholars 
                   ORDER BY name ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching scholars list: " . $e->getMessage());
            return [];
        }
    }

    public function getAllFeaturedScholars() {
        try {
            $sql = "SELECT fs.*, s.name, s.course, s.scholarship 
                    FROM featured_scholars fs
                    JOIN scholars s ON fs.sr_code = s.sr_code
                    ORDER BY fs.id DESC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching featured scholars: " . $e->getMessage());
            return [];
        }
    }

    public function addFeaturedScholar($srCode, $message, $status) {
        try {
            $sql = "INSERT INTO featured_scholars (sr_code, message, status) VALUES (?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            return $stmt->execute([$srCode, $message, $status]);
        } catch (PDOException $e) {
            error_log("Error adding featured scholar: " . $e->getMessage());
            return false;
        }
    }

    public function deleteFeaturedScholar($id) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM featured_scholars WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting featured scholar: " . $e->getMessage());
            return false;
        }
    }

    public function updateFeaturedScholar($id, $message, $status) {
        try {
            $sql = "UPDATE featured_scholars SET message = ?, status = ? WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            return $stmt->execute([$message, $status, $id]);
        } catch (PDOException $e) {
            error_log("Error updating featured scholar: " . $e->getMessage());
            return false;
        }
    }
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $handler = new FeaturedScholarsHandler();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? 'get_featured';
        
        if ($action === 'get_scholars_list') {
            $scholars = $handler->getScholarsList();
            echo json_encode(['status' => 'success', 'scholars' => $scholars]);
        } else {
            $featuredScholars = $handler->getAllFeaturedScholars();
            echo json_encode(['status' => 'success', 'scholar_data' => $featuredScholars]);
        }
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add_scholar':
                $result = $handler->addFeaturedScholar(
                    $_POST['sr_code'],
                    $_POST['message'],
                    $_POST['status']
                );
                echo json_encode([
                    'status' => $result ? 'success' : 'error',
                    'message' => $result ? 'Scholar featured successfully' : 'Failed to feature scholar'
                ]);
                break;

            case 'delete_scholar':
                $id = $_POST['id'] ?? '';
                if (empty($id)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Scholar ID is required'
                    ]);
                    break;
                }
                $result = $handler->deleteFeaturedScholar($id);
                echo json_encode([
                    'status' => $result ? 'success' : 'error',
                    'message' => $result ? 'Featured scholar removed successfully' : 'Failed to remove featured scholar'
                ]);
                break;

            case 'update_scholar':
                $result = $handler->updateFeaturedScholar(
                    $_POST['id'],
                    $_POST['message'],
                    $_POST['status']
                );
                echo json_encode([
                    'status' => $result ? 'success' : 'error',
                    'message' => $result ? 'Scholar updated successfully' : 'Failed to update scholar'
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