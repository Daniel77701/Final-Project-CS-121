<?php
include_once "database.php";

class Signup extends Database {
    protected function checkUser($email, $srcode) {
        $mysqli = $this->connect();
        
        $stmt = $mysqli->prepare("SELECT * FROM students WHERE email = ? OR sr_code = ?");
        if (!$stmt) {
            throw new Exception("Statement preparation failed");
        }
        
        $stmt->bind_param("ss", $email, $srcode);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception("Statement execution failed");
        }
        
        $result = $stmt->get_result();
        $rowCount = $result->num_rows;
        
        $stmt->close();
        return $rowCount === 0; // Returns true if user doesn't exist
    }

    protected function setUser($name, $email, $srcode, $mobile, $pwd) {
        $mysqli = $this->connect();
        
        $stmt = $mysqli->prepare("INSERT INTO students (name, email, sr_code, mobile_number, password) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Statement preparation failed");
        }
        
        $stmt->bind_param("sssss", $name, $email, $srcode, $mobile, $pwd);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception("Statement execution failed");
        }
        
        $stmt->close();
    }
}

?>
