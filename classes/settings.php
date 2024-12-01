<?php
class Settings extends Database {
    public function changePassword($userId, $currentPassword, $newPassword) {
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die("MySQLi Error: " . $this->conn->error);
        }

        $stmt->bind_param("i", $userId); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($currentPassword, $row['password'])) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                $updateStmt = $this->conn->prepare($updateQuery);

                if ($updateStmt === false) {
                    die("MySQLi Error: " . $this->conn->error);
                }

                $updateStmt->bind_param("si", $newPasswordHash, $userId); // "s" for string, "i" for integer
                $result = $updateStmt->execute();

                return $result;
            }
        }

        return false;
    }
}
?>
