<?php
require_once '../connection/dbh.classes.php';

class Login extends Dbh {
    protected $conn;

    public function __construct() {
        try {
            $this->conn = $this->connect();
        } catch (PDOException $e) {
            error_log("Login connection error: " . $e->getMessage());
            throw $e;
        }
    }
    
    protected function getUser($login_id, $pwd) {
        try {
            error_log("Attempting database query for login ID: " . $login_id);
            
            // Check if input is email or SR code
            $isEmail = strpos($login_id, '@') !== false;
            
            // Validate email format if it's an email
            if ($isEmail && !str_ends_with($login_id, '@g.batstate-u.edu.ph')) {
                error_log("Invalid email format: " . $login_id);
                return false;
            }
            
            $stmt = $this->conn->prepare("
                SELECT id, sr_code, name, email, password 
                FROM students 
                WHERE " . ($isEmail ? "email = ?" : "sr_code = ?") . "
                LIMIT 1
            ");
            
            if (!$stmt->execute([$login_id])) {
                error_log("Database query failed");
                throw new Exception("Database query failed");
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                error_log("No user found with login ID: " . $login_id);
                return false;
            }

            if ($pwd === $user['password']) {
                error_log("Password match successful");
                return $user;
            }

            error_log("Password match failed");
            return false;

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw $e;
        }
    }

    protected function checkUser($sr_code) {
        $stmt = $this->conn->prepare('SELECT sr_code FROM students WHERE sr_code = ?;');

        if(!$stmt->execute(array($sr_code))) {
            $stmt = null;
            throw new Exception("Statement failed");
        }

        return $stmt->rowCount() > 0;
    }
}
?>
