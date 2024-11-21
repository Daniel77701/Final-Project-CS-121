<?php

class Login extends Dbh {

    protected function getStudent($email, $Sr_code, $password) {
        $stmt = $this->connect()->prepare('SELECT * FROM students WHERE Sr_code = ? OR email = ?');
    
        if (!$stmt->execute(array($Sr_code, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../index.php?error=usernotfound");
            exit();
        }

        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $student["password"]);

        if (!$checkPassword) {
            $stmt = null;
            header("location: ../index.php?error=wrongpassword");
            exit();
        }

        session_start();
        $_SESSION["id"] = $student["id"];
        $_SESSION["Sr_code"] = $student["Sr_code"];
        $_SESSION["name"] = $student["Name"];
        
        $stmt = null;
    }
}

?>
