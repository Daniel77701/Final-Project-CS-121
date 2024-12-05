<?php
require_once '../connection/dbh.classes.php';

class SettingHandler extends Dbh {
    // Handle settings creation
    public function createSetting($schoolYear, $semester) {
        $sql = "INSERT INTO settings (school_year, semester, status) VALUES (?, ?, 'Active')";
        $stmt = $this->connect()->prepare($sql);
        
        if (!$stmt->execute([$schoolYear, $semester])) {
            throw new Exception("Failed to create setting");
        }
        return true;
    }

    // Handle settings deletion
    public function deleteSetting($id) {
        $sql = "DELETE FROM settings WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        
        if (!$stmt->execute([$id])) {
            throw new Exception("Failed to delete setting");
        }
        return true;
    }

    // Get all settings
    public function getAllSettings() {
        $sql = "SELECT * FROM settings ORDER BY created_at DESC";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}