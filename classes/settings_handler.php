<?php
require_once '../connection/dbh.classes.php';

class SettingHandler extends Dbh {
    // Handle settings creation
    public function createSetting($schoolYear, $semester) {
        try {
            // Check for duplicate school year and semester
            $checkSql = "SELECT COUNT(*) FROM settings WHERE school_year = ? AND semester = ? AND status = 'Active'";
            $checkStmt = $this->connect()->prepare($checkSql);
            $checkStmt->execute([$schoolYear, $semester]);
            
            if ($checkStmt->fetchColumn() > 0) {
                throw new Exception("This school year and semester combination already exists");
            }

            $sql = "INSERT INTO settings (school_year, semester, status) VALUES (?, ?, 'Active')";
            $stmt = $this->connect()->prepare($sql);
            
            if (!$stmt->execute([$schoolYear, $semester])) {
                throw new Exception("Failed to create setting");
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    // Get setting by ID
    public function getSettingById($id) {
        try {
            $sql = "SELECT * FROM settings WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            
            $setting = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$setting) {
                throw new Exception("Setting not found");
            }
            
            return $setting;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    // Update setting
    public function updateSetting($id, $schoolYear, $semester, $status = null) {
        try {
            // Check if setting exists
            $checkSql = "SELECT * FROM settings WHERE id = ?";
            $checkStmt = $this->connect()->prepare($checkSql);
            $checkStmt->execute([$id]);
            
            if (!$checkStmt->fetch()) {
                throw new Exception("Setting not found");
            }

            // Check for duplicates excluding current record
            $dupeSql = "SELECT COUNT(*) FROM settings WHERE school_year = ? AND semester = ? AND id != ? AND status = 'Active'";
            $dupeStmt = $this->connect()->prepare($dupeSql);
            $dupeStmt->execute([$schoolYear, $semester, $id]);
            
            if ($dupeStmt->fetchColumn() > 0) {
                throw new Exception("This school year and semester combination already exists");
            }

            // Update the setting
            if ($status !== null) {
                $sql = "UPDATE settings SET school_year = ?, semester = ?, status = ? WHERE id = ?";
                $stmt = $this->connect()->prepare($sql);
                $result = $stmt->execute([$schoolYear, $semester, $status, $id]);
            } else {
                $sql = "UPDATE settings SET school_year = ?, semester = ? WHERE id = ?";
                $stmt = $this->connect()->prepare($sql);
                $result = $stmt->execute([$schoolYear, $semester, $id]);
            }

            if (!$result) {
                throw new Exception("Failed to update setting");
            }
            
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    // Handle settings deletion (soft delete)
    public function deleteSetting($id) {
        try {
            // Check if setting exists
            $checkSql = "SELECT * FROM settings WHERE id = ?";
            $checkStmt = $this->connect()->prepare($checkSql);
            $checkStmt->execute([$id]);
            
            if (!$checkStmt->fetch()) {
                throw new Exception("Setting not found");
            }

            $sql = "UPDATE settings SET status = 'Inactive' WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            
            if (!$stmt->execute([$id])) {
                throw new Exception("Failed to delete setting");
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    // Get all active settings
    public function getAllSettings() {
        try {
            $sql = "SELECT * FROM settings WHERE status = 'Active' ORDER BY created_at DESC";
            $stmt = $this->connect()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}