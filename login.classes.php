<?php
include_once "database.php";

class Login extends Database {
    protected function getUser($email, $pwd) {
        $mysqli = $this->connect();
        
        $stmt = $mysqli->prepare("SELECT * FROM students WHERE email = ? OR sr_code = ?");
        if (!$stmt) {
            throw new Exception("Statement preparation failed");
        }
        
        $stmt->bind_param("ss", $email, $email);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception("Statement execution failed");
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            $stmt->close();
            throw new Exception("usernotfound");
        }
        
        $user = $result->fetch_assoc();
        
        if ($pwd === $user['password']) {
            $stmt->close();
            return $user;
        }
        
        $stmt->close();
        throw new Exception("wrongpassword");
    }
}

?>
