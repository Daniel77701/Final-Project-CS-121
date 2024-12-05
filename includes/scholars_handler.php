<?php
require_once '../classes/dbh.classes.php';

class scholars_handler extends Dbh {
    public function getScholars() {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM scholars ORDER BY sr_code");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching scholars: " . $e->getMessage());
            return [];
        }
    }

    public function addScholar($sr_code, $name, $course, $year_level, $scholarship) {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO scholars (sr_code, name, course, year_level, scholarship) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$sr_code, $name, $course, $year_level, $scholarship]);
        } catch (PDOException $e) {
            error_log("Error adding scholar: " . $e->getMessage());
            return false;
        }
    }

    public function updateScholar($sr_code, $name, $course, $year_level, $scholarship) {
        try {
            $stmt = $this->connect()->prepare("UPDATE scholars SET name = ?, course = ?, year_level = ?, scholarship = ? WHERE sr_code = ?");
            return $stmt->execute([$name, $course, $year_level, $scholarship, $sr_code]);
        } catch (PDOException $e) {
            error_log("Error updating scholar: " . $e->getMessage());
            return false;
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
} 