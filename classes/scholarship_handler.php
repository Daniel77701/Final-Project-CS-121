<?php
require_once "../connection/dbh.classes.php";

class ScholarshipHandler extends Dbh {
    public function getScholarships() {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM scholarships ORDER BY scholarship_id ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching scholarships: " . $e->getMessage());
            return [];
        }
    }

    public function create($scholarship_id, $name, $description, $requirements, $status) {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO scholarships (scholarship_id, name, description, requirements, status) 
                    VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$scholarship_id, $name, $description, $requirements, $status]);
        } catch (PDOException $e) {
            error_log("Error creating scholarship: " . $e->getMessage());
            return false;
        }
    }

    public function update($scholarship_id, $name, $description, $requirements, $status) {
        try {
            $stmt = $this->connect()->prepare("UPDATE scholarships 
                    SET name = ?, description = ?, requirements = ?, status = ? 
                    WHERE scholarship_id = ?");
            return $stmt->execute([$name, $description, $requirements, $status, $scholarship_id]);
        } catch (PDOException $e) {
            error_log("Error updating scholarship: " . $e->getMessage());
            return false;
        }
    }

    public function delete($scholarship_id) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM scholarships WHERE scholarship_id = ?");
            return $stmt->execute([$scholarship_id]);
        } catch (PDOException $e) {
            error_log("Error deleting scholarship: " . $e->getMessage());
            return false;
        }
    }

    public function checkIdExists($scholarship_id) {
        try {
            $stmt = $this->connect()->prepare("SELECT COUNT(*) FROM scholarships WHERE scholarship_id = ?");
            $stmt->execute([$scholarship_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking scholarship ID: " . $e->getMessage());
            return false;
        }
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scholarship = new ScholarshipHandler();
    
    if (isset($_POST['add_scholarship'])) {
        $scholarship->create(
            $_POST['scholarship_id'],
            $_POST['name'],
            $_POST['description'],
            $_POST['requirements'],
            $_POST['status']
        );
        header("Location: ../scholarship.php?status=added");
        exit();
    }
    
    if (isset($_POST['update_scholarship'])) {
        $scholarship->update(
            $_POST['scholarship_id'],
            $_POST['name'],
            $_POST['description'],
            $_POST['requirements'],
            $_POST['status']
        );
        header("Location: ../scholarship.php?status=updated");
        exit();
    }
}

// Handle delete requests
if (isset($_GET['delete_scholarship_id'])) {
    $scholarship = new ScholarshipHandler();
    $scholarship->delete($_GET['delete_scholarship_id']);
    header("Location: ../scholarship.php?status=deleted");
    exit();
} 