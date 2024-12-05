<?php
require_once '../connection/dbh.classes.php';

class LoginTracker extends Dbh {
    // Start tracking login session
    public function startLoginSession($sr_code) {
        try {
            // First get the student's ID using sr_code
            $query = "SELECT id FROM students WHERE sr_code = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$sr_code]);
            $student = $stmt->fetch();
            
            if (!$student) {
                return false;
            }

            $studentId = $student['id'];
            $loginTime = date('Y-m-d H:i:s');
            
            $query = "INSERT INTO user_logs (student_id, login_time) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$studentId, $loginTime]);
            
            // Store the login ID and student info in session
            $_SESSION['login_id'] = $this->connect()->lastInsertId();
            $_SESSION['login_time'] = $loginTime;
            $_SESSION['student_id'] = $studentId;
            
            return true;
        } catch (PDOException $e) {
            error_log("Error starting login session: " . $e->getMessage());
            return false;
        }
    }

    // End tracking login session
    public function endLoginSession($sr_code) {
        try {
            if (isset($_SESSION['login_id']) && isset($_SESSION['student_id'])) {
                $logoutTime = date('Y-m-d H:i:s');
                $loginId = $_SESSION['login_id'];
                $studentId = $_SESSION['student_id'];
                
                // Calculate duration in seconds
                $duration = strtotime($logoutTime) - strtotime($_SESSION['login_time']);
                
                $query = "UPDATE user_logs 
                         SET logout_time = ?, duration = ? 
                         WHERE id = ? AND student_id = ?";
                
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([$logoutTime, $duration, $loginId, $studentId]);
                
                // Clear session variables
                unset($_SESSION['login_id']);
                unset($_SESSION['login_time']);
                unset($_SESSION['student_id']);
                
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error ending login session: " . $e->getMessage());
            return false;
        }
    }

    // Get total login duration for a student
    public function getTotalLoginDuration($sr_code) {
        try {
            $query = "SELECT SUM(ul.duration) as total_duration 
                     FROM user_logs ul
                     JOIN students s ON s.id = ul.student_id
                     WHERE s.sr_code = ? 
                     AND ul.duration IS NOT NULL";
            
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$sr_code]);
            $result = $stmt->fetch();
            
            return $result['total_duration'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error getting total duration: " . $e->getMessage());
            return 0;
        }
    }

    // Get login history for a student
    public function getLoginHistory($sr_code) {
        try {
            $query = "SELECT ul.*, s.name, s.sr_code 
                     FROM user_logs ul
                     JOIN students s ON s.id = ul.student_id
                     WHERE s.sr_code = ? 
                     ORDER BY ul.login_time DESC";
            
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$sr_code]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting login history: " . $e->getMessage());
            return [];
        }
    }

    // Get current session duration
    public function getCurrentSessionDuration($sr_code) {
        if (isset($_SESSION['login_time'])) {
            $currentTime = time();
            $loginTime = strtotime($_SESSION['login_time']);
            return $currentTime - $loginTime;
        }
        return 0;
    }

    // Format duration into readable time
    public function formatDuration($seconds) {
        if ($seconds < 60) {
            return $seconds . " seconds";
        }
        
        $minutes = floor($seconds / 60);
        if ($minutes < 60) {
            return $minutes . " minutes";
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours < 24) {
            return $hours . " hours " . $remainingMinutes . " minutes";
        }
        
        $days = floor($hours / 24);
        $remainingHours = $hours % 24;
        
        return $days . " days " . $remainingHours . " hours";
    }
}