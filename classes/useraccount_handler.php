<?php

require_once __DIR__ . "/../connection/dbh.classes.php";
class UserAccountHandler extends Dbh {

    protected function getConnection() {
        try {
            return parent::connect();
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public function getStudents($search = '', $page = 1) {
        try {
            $records_per_page = 10;
            $offset = ($page - 1) * $records_per_page;
            
            $where_clause = '';
            $params = [];
            if ($search) {
                $where_clause = " WHERE name LIKE ? OR email LIKE ? OR sr_code LIKE ?";
                $search_param = "%$search%";
                $params = [$search_param, $search_param, $search_param];
            }

            $conn = $this->getConnection();

            // Get total records
            $total_query = "SELECT COUNT(*) as count FROM students" . $where_clause;
            $stmt = $conn->prepare($total_query);
            if ($search) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }
            $total_records = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            $total_pages = ceil($total_records / $records_per_page);

            // Get students with pagination
            $sql = "SELECT id, email, sr_code, name FROM students";
            if ($search) {
                $sql .= $where_clause;
            }
            $sql .= " ORDER BY id DESC LIMIT " . (int)$offset . ", " . (int)$records_per_page;
            
            $stmt = $conn->prepare($sql);
            
            if ($search) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }

            return [
                'users' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'total_records' => $total_records,
                'total_pages' => $total_pages
            ];
            
        } catch (PDOException $e) {
            error_log("Error in getStudents: " . $e->getMessage());
            throw new Exception("Database error occurred: " . $e->getMessage());
        }
    }

    public function addStudent($name, $email, $sr_code, $password) {
        try {
            $conn = $this->getConnection();
            
            // Check if email or sr_code already exists
            $check_sql = "SELECT id FROM students WHERE email = ? OR sr_code = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([$email, $sr_code]);
            
            if ($check_stmt->rowCount() > 0) {
                throw new Exception("Email or SR Code already exists");
            }

            $sql = "INSERT INTO students (name, email, sr_code, password) VALUES (?, ?, ?, ?)";
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare($sql);
            if (!$stmt->execute([$name, $email, $sr_code, $hashed_password])) {
                throw new Exception("Failed to add student");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in addStudent: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    public function updateStudent($id, $name, $email, $sr_code) {
        try {
            $conn = $this->getConnection();
            
            // Check if email or sr_code already exists for different student
            $check_sql = "SELECT id FROM students WHERE (email = ? OR sr_code = ?) AND id != ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([$email, $sr_code, $id]);
            
            if ($check_stmt->rowCount() > 0) {
                throw new Exception("Email or SR Code already exists");
            }

            $sql = "UPDATE students SET name = ?, email = ?, sr_code = ? WHERE id = ?";
            
            $stmt = $conn->prepare($sql);
            if (!$stmt->execute([$name, $email, $sr_code, $id])) {
                throw new Exception("Failed to update student");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in updateStudent: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    public function deleteStudent($id) {
        try {
            $conn = $this->getConnection();
            
            $sql = "DELETE FROM students WHERE id = ?";
            
            $stmt = $conn->prepare($sql);
            if (!$stmt->execute([$id])) {
                throw new Exception("Failed to delete student");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in deleteStudent: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }
}
?>