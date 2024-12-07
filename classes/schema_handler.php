<?php
require_once '../connection/dbh.classes.php';

class Schema extends Dbh {
    private $conn;
    
    public function __construct() {
        $this->conn = $this->connect();
    }

    public function fetchAll() {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM scholarship_schema 
                 WHERE status = 'Open' 
                 ORDER BY published_date DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching schemas: " . $e->getMessage());
            return [];
        }
    }

    public function getSchemaById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM scholarship_schema WHERE schema_id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                return ['error' => 'Schema not found'];
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error getting schema: " . $e->getMessage());
            return ['error' => 'Database error occurred'];
        }
    }

    public function deleteSchema($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM scholarship_schema WHERE schema_id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting schema: " . $e->getMessage());
            return false;
        }
    }

    public function updateSchema($data) {
        try {
            $sql = "UPDATE scholarship_schema SET 
                scholarship_type = ?,
                grade_campus = ?,
                year_scholarship = ?,
                category = ?,
                criteria = ?,
                submission_deadline = ?,
                required_documents = ?,
                description = ?,
                amount_per_sem = ?,
                status = ?,
                published_date = CURRENT_TIMESTAMP
                WHERE schema_id = ?";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $data['scholarshipType'],
                $data['gradeCampus'],
                $data['yearScholarship'],
                $data['category'],
                $data['criteria'],
                $data['submissionDeadline'],
                $data['requiredDocuments'],
                $data['description'],
                $data['amountPerSem'],
                $data['status'],
                $data['schema_id']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating schema: " . $e->getMessage());
            return false;
        }
    }

    public function getActiveSchemaCount() {
        try {
            $stmt = $this->conn->prepare(
                "SELECT COUNT(*) as count 
                 FROM scholarship_schema 
                 WHERE status = 'Open'"
            );
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error counting active schemas: " . $e->getMessage());
            return 0;
        }
    }
}
?>
