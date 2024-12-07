<?php
require_once '../connection/dbh.classes.php';

class ScholarsHandler extends Dbh {
    public function getScholars() {
        try {
            // Join with scholarships table to get all relevant scholarship info
            $stmt = $this->connect()->prepare("
                SELECT s.sr_code, s.name, s.course, s.year_level, 
                       sch.scholarship_id, sch.name as scholarship_name,
                       sch.description, sch.deadline, sch.requirements,
                       sch.status
                FROM scholars s
                LEFT JOIN scholarships sch ON s.scholarship_id = sch.scholarship_id
                WHERE sch.status = 'active'
                ORDER BY s.sr_code
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching scholars: " . $e->getMessage());
            return [];
        }
    }

    public function addScholar($sr_code, $name, $course, $year_level, $scholarship_id) {
        try {
            // Check for empty inputs
            if (empty($sr_code) || empty($course) || empty($year_level) || empty($scholarship_id)) {
                throw new Exception("All fields are required");
            }

            if (!$this->isValidSRCode($sr_code)) {
                throw new Exception("Invalid SR code format. Must follow pattern: XX-XXXXX (e.g., 23-56748)");
            }

            // Verify that this is a registered student
            $query = "SELECT name FROM students WHERE sr_code = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$sr_code]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$student) {
                throw new Exception("SR Code not found in student records. Only registered students can become scholars.");
            }

            // Verify that the scholarship exists and is active
            $query = "SELECT scholarship_id FROM scholarships WHERE scholarship_id = ? AND scholarships.status = 'active'";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$scholarship_id]);
            if (!$stmt->fetch()) {
                throw new Exception("Invalid or inactive scholarship selected");
            }

            // Use the student's name from the students table to ensure consistency
            $stmt = $this->connect()->prepare("
                INSERT INTO scholars (sr_code, name, course, year_level, scholarship_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$sr_code, $student['name'], $course, $year_level, $scholarship_id]);
        } catch (PDOException $e) {
            error_log("Error adding scholar: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function updateScholar($sr_code, $name, $course, $year_level, $scholarship_id) {
        try {
            // Check for empty inputs
            if (empty($sr_code) || empty($name) || empty($course) || empty($year_level) || empty($scholarship_id)) {
                throw new Exception("All fields are required");
            }

            // Verify that the scholarship exists and is active
            $query = "SELECT scholarship_id FROM scholarships WHERE scholarship_id = ? AND scholarships.status = 'active'";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$scholarship_id]);
            if (!$stmt->fetch()) {
                throw new Exception("Invalid or inactive scholarship selected");
            }

            $stmt = $this->connect()->prepare("
                UPDATE scholars 
                SET name = ?, course = ?, year_level = ?, scholarship_id = ? 
                WHERE sr_code = ?
            ");
            return $stmt->execute([$name, $course, $year_level, $scholarship_id, $sr_code]);
        } catch (PDOException $e) {
            error_log("Error updating scholar: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function deleteScholar($sr_code) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM scholars WHERE sr_code = ?");
            return $stmt->execute([$sr_code]);
        } catch (PDOException $e) {
            error_log("Error deleting scholar: " . $e->getMessage());
            return false;
        }
    }

    public function checkSRCodeExists($sr_code) {
        try {
            if (!$this->isValidSRCode($sr_code)) {
                throw new Exception("Invalid SR code format. Must follow pattern: XX-XXXXX (e.g., 23-56748)");
            }

            // First check if the SR code exists in the students table
            $query = "SELECT COUNT(*) FROM students WHERE sr_code = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$sr_code]);
            $studentExists = $stmt->fetchColumn() > 0;

            if (!$studentExists) {
                throw new Exception("SR Code not found in student records. Only registered students can become scholars.");
            }

            // Then check if they're already a scholar
            $query = "SELECT COUNT(*) FROM scholars WHERE sr_code = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$sr_code]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking SR code existence: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    private function isValidSRCode($sr_code) {
        return preg_match('/^\d{2}-\d{5}$/', $sr_code);
    }

    // Add method to get available scholarships
    public function getAvailableScholarships() {
        try {
            $stmt = $this->connect()->prepare("
                SELECT scholarship_id, name, description, deadline, requirements, status
                FROM scholarships 
                WHERE scholarships.status = 'active'
                ORDER BY name
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug log
            error_log("Available scholarships: " . print_r($results, true));
            
            return $results;
        } catch (PDOException $e) {
            error_log("Error fetching scholarships: " . $e->getMessage());
            return [];
        }
    }
} 