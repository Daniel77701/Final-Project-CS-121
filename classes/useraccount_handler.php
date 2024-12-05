<?php

require_once "../connection/dbh.classes.php";
class UserAccountHandler extends Dbh {

    public function getUsers($page = 1, $search = '') {
        $records_per_page = 10;
        $offset = ($page - 1) * $records_per_page;
        
        $where_clause = '';
        $params = [];
        if ($search) {
            $where_clause = " WHERE full_name LIKE ? OR email LIKE ? OR sr_code LIKE ?";
            $search_param = "%$search%";
            $params = [$search_param, $search_param, $search_param];
        }

        // Get total records
        $total_query = "SELECT COUNT(*) as count FROM users_account" . $where_clause;
        $stmt = $this->connect()->prepare($total_query);
        if ($search) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }
        $total_records = $stmt->fetch()['count'];
        $total_pages = ceil($total_records / $records_per_page);

        $sql = "SELECT id, email, sr_code, full_name FROM users_account" . $where_clause . 
               " ORDER BY id DESC LIMIT ?, ?";
        $stmt = $this->connect()->prepare($sql);
        
        if ($search) {
            $params[] = $offset;
            $params[] = $records_per_page;
            $stmt->execute($params);
        } else {
            $stmt->execute([$offset, $records_per_page]);
        }

        return [
            'users' => $stmt->fetchAll(),
            'total_records' => $total_records,
            'total_pages' => $total_pages
        ];
    }

    // Add new user
    public function addUser($full_name, $email, $sr_code, $password) {
        $sql = "INSERT INTO users_account (full_name, email, sr_code, password) VALUES (?, ?, ?, ?)";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute([$full_name, $email, $sr_code, $hashed_password])) {
            throw new Exception("Failed to add user");
        }
        return true;
    }

    // Update user
    public function updateUser($id, $full_name, $email, $sr_code) {
        $sql = "UPDATE users_account SET full_name=?, email=?, sr_code=? WHERE id=?";
        
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute([$full_name, $email, $sr_code, $id])) {
            throw new Exception("Failed to update user");
        }
        return true;
    }

    // Delete user
    public function deleteUser($id) {
        $sql = "DELETE FROM users_account WHERE id=?";
        
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute([$id])) {
            throw new Exception("Failed to delete user");
        }
        return true;
    }
}
?>