<?php

class Signup extends Dbh {

    protected function setStudent($Name, $email, $Sr_code, $Mobilenum, $password) {
        $stmt = $this->connect()->prepare('INSERT INTO students (Name, email, Sr_code, Mobilenum, password) VALUES (?, ?, ?, ?, ?)');

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute([$Name, $email, $Sr_code, $Mobilenum, $hashedPwd])) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkStudent($Sr_code, $email) {
        $stmt = $this->connect()->prepare('SELECT * FROM students WHERE Sr_code = ? OR email = ?');

        if (!$stmt->execute([$Sr_code, $email])) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        return $stmt->rowCount() > 0;
    }
}

?>
