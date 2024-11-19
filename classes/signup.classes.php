<?php

class Signup extends Dbh {

    protected function setUser($Name, $email, $Sr_code, $Mobilenum, $password) {
        $stmt = $this->connect()->prepare('INSERT INTO users (Name, email, Sr_code, Mobilenum, password) VALUES (?, ?, ?, ?, ?)');

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute([$Name, $email, $Sr_code, $Mobilenum, $hashedPwd])) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($Name, $email) {
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE Name = ? OR email = ?');

        if (!$stmt->execute([$Name, $email])) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        return $stmt->rowCount() > 0;
    }
}
