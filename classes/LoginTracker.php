<?php
require_once '../connection/dbh.classes.php';

class LoginTracker extends Dbh {
    private $conn;

    public function __construct() {
        $this->conn = $this->connect();
    }

    public function logLogin($studentId) {
        try {
            // Check for existing active session
            $query = "SELECT COUNT(*) as active_count FROM user_logs WHERE student_id = ? AND logout_time IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$studentId]);
            $activeCount = $stmt->fetchColumn();

            if ($activeCount > 0) {
                // If there is already an active session, return false or handle accordingly
                return false; // Or throw an exception
            }

            // If no active session, log the new login
            $query = "INSERT INTO user_logs (student_id, login_time) VALUES (?, NOW())";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$studentId]);
        } catch (PDOException $e) {
            error_log("Error logging login: " . $e->getMessage());
            return false;
        }
    }

    public function logLogout($studentId) {
        try {
            $query = "UPDATE user_logs 
                     SET logout_time = NOW(),
                         duration = TIMESTAMPDIFF(SECOND, login_time, NOW())
                     WHERE student_id = ? 
                     AND logout_time IS NULL";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$studentId]);
        } catch (PDOException $e) {
            error_log("Error logging logout: " . $e->getMessage());
            return false;
        }
    }

    public function formatDuration($seconds) {
        if ($seconds < 60) {
            return $seconds . " seconds";
        } elseif ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            return $minutes . " minute" . ($minutes != 1 ? "s" : "");
        } elseif ($seconds < 86400) {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            return $hours . " hour" . ($hours != 1 ? "s" : "") . 
                   ($minutes > 0 ? " " . $minutes . " minute" . ($minutes != 1 ? "s" : "") : "");
        } else {
            $days = floor($seconds / 86400);
            $hours = floor(($seconds % 86400) / 3600);
            return $days . " day" . ($days != 1 ? "s" : "") . 
                   ($hours > 0 ? " " . $hours . " hour" . ($hours != 1 ? "s" : "") : "");
        }
    }

    public function endLoginSession($studentId) {
        $query = "UPDATE user_logs SET logout_time = NOW() WHERE student_id = ? AND logout_time IS NULL";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$studentId]);
    }
}