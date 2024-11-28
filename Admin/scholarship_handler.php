<?php
require_once "../dbh.classes.php";

class ScholarshipHandler extends Dbh {

    // Create a new scholarship
    public function create($name, $description, $requirements, $deadline) {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO scholarships (name, description, requirements, deadline) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $description, $requirements, $deadline]);
            return ['status' => 'success', 'message' => 'Scholarship added successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Read scholarships (all or by ID)
    public function read($scholarship_id = null) {
        try {
            if ($scholarship_id) {
                $stmt = $this->connect()->prepare("SELECT * FROM scholarships WHERE scholarship_id = ?");
                $stmt->execute([$scholarship_id]);
                return $stmt->fetch();
            } else {
                $stmt = $this->connect()->query("SELECT * FROM scholarships ORDER BY created_at DESC");
                return $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Update an existing scholarship
    public function update($scholarship_id, $name, $description, $requirements, $deadline) {
        try {
            $stmt = $this->connect()->prepare("UPDATE scholarships SET name = ?, description = ?, requirements = ?, deadline = ? WHERE scholarship_id = ?");
            $stmt->execute([$name, $description, $requirements, $deadline, $scholarship_id]);
            return ['status' => 'success', 'message' => 'Scholarship updated successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Delete a scholarship
    public function delete($scholarship_id) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM scholarships WHERE scholarship_id = ?");
            $stmt->execute([$scholarship_id]);
            return ['status' => 'success', 'message' => 'Scholarship deleted successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
