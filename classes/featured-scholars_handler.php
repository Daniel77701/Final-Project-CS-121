<?php
require_once "../connection/dbh.classes.php";

class FeaturedScholarsHandler extends Dbh {
    // Get list of all scholars for dropdown
    public function getScholarsList() {
        try {
            error_log("=== Debug getScholarsList ===");
            
            // Get all scholars that aren't featured yet
            $sql = "SELECT DISTINCT s.sr_code, s.name, s.course, sch.name as scholarship 
                   FROM scholars s
                   LEFT JOIN scholarships sch ON s.scholarship_id = sch.scholarship_id 
                   WHERE s.sr_code NOT IN (
                       SELECT sr_code FROM featured_scholars
                   )
                   AND s.name IS NOT NULL 
                   AND s.course IS NOT NULL
                   ORDER BY s.name ASC";
            
            error_log("SQL Query: " . $sql);
            
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("Number of scholars found: " . count($results));
            error_log("Scholar data: " . print_r($results, true));
            
            return $results;
        } catch (PDOException $e) {
            error_log("Error in getScholarsList: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return [];
        }
    }

    public function getAllFeaturedScholars() {
        try {
            $sql = "SELECT fs.*, s.name, s.course, sch.name as scholarship 
                    FROM featured_scholars fs
                    JOIN scholars s ON fs.sr_code = s.sr_code
                    LEFT JOIN scholarships sch ON s.scholarship_id = sch.scholarship_id
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
            echo json_encode([
                'status' => 'success',
                'scholars' => $scholars,
                'debug_count' => count($scholars) // Debug info
            ]);
            exit();
        } else {
            $featuredScholars = $handler->getAllFeaturedScholars();
            echo json_encode([
                'status' => 'success',
                'scholar_data' => $featuredScholars
            ]);
            exit();
        }
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