<?php
require_once "../dbh.classes.php";

class ScholarshipRequest {
    private $conn;

    public function __construct() {
        $this->conn = (new Dbh())->connect();
    }

    // Read requests
    public function readRequests() {
        $sql = "SELECT * FROM scholarship_requests";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new request
    public function createRequest($type, $scholarship, $student_no, $name, $course, $year_level) {
        // Check if the table is empty and reset auto-increment
        $sqlCheckEmpty = "SELECT COUNT(*) FROM scholarship_requests";
        $stmtCheckEmpty = $this->conn->query($sqlCheckEmpty);
        $count = $stmtCheckEmpty->fetchColumn();

        if ($count == 0) {
            // If the table is empty, reset AUTO_INCREMENT to 1
            $sqlResetAutoIncrement = "ALTER TABLE scholarship_requests AUTO_INCREMENT = 1";
            $this->conn->query($sqlResetAutoIncrement);
        }

        // Insert new request
        $sql = "INSERT INTO scholarship_requests (type, scholarship, student_no, name, course, year_level) 
                VALUES (:type, :scholarship, :student_no, :name, :course, :year_level)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':scholarship', $scholarship);
        $stmt->bindParam(':student_no', $student_no);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':year_level', $year_level);

        if ($stmt->execute()) {
            return ['success' => 'Request added successfully'];
        } else {
            return ['error' => 'Failed to add request'];
        }
    }

    // Update request details
    public function updateRequest($id, $type, $scholarship, $student_no, $name, $course, $year_level) {
        $sql = "UPDATE scholarship_requests SET type = :type, scholarship = :scholarship, student_no = :student_no, 
                name = :name, course = :course, year_level = :year_level WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':scholarship', $scholarship);
        $stmt->bindParam(':student_no', $student_no);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':year_level', $year_level);

        if ($stmt->execute()) {
            return ['success' => 'Request updated successfully'];
        } else {
            return ['error' => 'Failed to update request'];
        }
    }

    // Delete a request
    public function deleteRequest($id) {
        $sql = "DELETE FROM scholarship_requests WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // After deletion, check the max id in the table and reset auto-increment
            $sqlMaxId = "SELECT MAX(id) FROM scholarship_requests";
            $stmtMaxId = $this->conn->query($sqlMaxId);
            $maxId = $stmtMaxId->fetchColumn();

            // Reset AUTO_INCREMENT to the next available id (maxId + 1 or 1 if table is empty)
            $newAutoIncrement = $maxId + 1;
            $sqlResetAutoIncrement = "ALTER TABLE scholarship_requests AUTO_INCREMENT = $newAutoIncrement";
            $this->conn->query($sqlResetAutoIncrement);

            return ['success' => 'Request deleted successfully'];
        } else {
            return ['error' => 'Failed to delete request'];
        }
    }
}

class ScholarshipRequestHandler {
    private $scholarshipRequest;

    public function __construct() {
        $this->scholarshipRequest = new ScholarshipRequest();
    }

    // Handle the request actions
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'read':
                    $this->readRequests();
                    break;
                case 'create':
                    $this->createRequest();
                    break;
                case 'update':
                    $this->updateRequest();
                    break;
                case 'delete':
                    $this->deleteRequest();
                    break;
                default:
                    echo json_encode(['error' => 'Invalid action']);
            }
        }
    }

    // Fetch all requests
    private function readRequests() {
        $requests = $this->scholarshipRequest->readRequests();
        echo json_encode($requests);
    }

    // Create a new request
    private function createRequest() {
        if (isset($_POST['type'], $_POST['scholarship'], $_POST['student_no'], $_POST['name'], $_POST['course'], $_POST['year_level'])) {
            $type = $_POST['type'];
            $scholarship = $_POST['scholarship'];
            $student_no = $_POST['student_no'];
            $name = $_POST['name'];
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];

            $response = $this->scholarshipRequest->createRequest($type, $scholarship, $student_no, $name, $course, $year_level);
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Missing required fields']);
        }
    }

    // Update a request
    private function updateRequest() {
        if (isset($_POST['id'], $_POST['type'], $_POST['scholarship'], $_POST['student_no'], $_POST['name'], $_POST['course'], $_POST['year_level'])) {
            $id = $_POST['id'];
            $type = $_POST['type'];
            $scholarship = $_POST['scholarship'];
            $student_no = $_POST['student_no'];
            $name = $_POST['name'];
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];

            $response = $this->scholarshipRequest->updateRequest($id, $type, $scholarship, $student_no, $name, $course, $year_level);
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Missing required fields']);
        }
    }

    // Delete a request
    private function deleteRequest() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $response = $this->scholarshipRequest->deleteRequest($id);
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Missing request ID']);
        }
    }
}

// Instantiate and handle the request
$requestHandler = new ScholarshipRequestHandler();
$requestHandler->handleRequest();
?>