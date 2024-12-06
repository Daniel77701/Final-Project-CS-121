<?php
require_once '../connection/dbh.classes.php';

class ScholarshipHandler extends Dbh {
    private $conn;

    public function __construct() {
        try {
            $this->conn = $this->connect();
            if (!$this->conn) {
                throw new Exception("Failed to establish database connection");
            }
        } catch (Exception $e) {
            error_log("ScholarshipHandler initialization error: " . $e->getMessage());
            throw $e;
        }
    }

    // Create new scholarship
    public function createScholarship($name, $description, $deadline, $requirements, $status = 'active') {
        try {
            $query = "SELECT MAX(CAST(scholarship_id AS UNSIGNED)) as max_id FROM scholarships";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $new_id = ($result['max_id'] ?? 0) + 1;
            
            $query = "INSERT INTO scholarships (scholarship_id, name, description, deadline, requirements, status) 
                      VALUES (:id, :name, :description, :deadline, :requirements, :status)";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'id' => $new_id,
                'name' => $name,
                'description' => $description,
                'deadline' => $deadline,
                'requirements' => $requirements,
                'status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Error creating scholarship: " . $e->getMessage());
            throw new Exception("Failed to create scholarship: " . $e->getMessage());
        }
    }

    // Read all scholarships
    public function getScholarships() {
        $query = "SELECT * FROM scholarships ORDER BY scholarship_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read single scholarship
    public function getScholarshipById($id) {
        $sql = "SELECT * FROM scholarships WHERE scholarship_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update scholarship
    public function updateScholarship($id, $name, $description, $deadline, $requirements, $status) {
        $sql = "UPDATE scholarships 
                SET name = ?, description = ?, deadline = ?, 
                    requirements = ?, status = ? 
                WHERE scholarship_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description, $deadline, $requirements, $status, $id]);
    }

    // Delete scholarship
    public function deleteScholarship($id) {
        $sql = "DELETE FROM scholarships WHERE scholarship_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Check if scholarship ID exists
    public function checkScholarshipExists($id) {
        $sql = "SELECT COUNT(*) FROM scholarships WHERE scholarship_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
} 