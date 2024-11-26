<?php
require_once "../dbh.classes.php";

class UserAccountHandler extends Dbh {
    public function fetchAllUsers() {
        $sql = "SELECT id, full_name, email, sr_code, mobile_number FROM students ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($full_name, $email, $sr_code, $mobile_number, $password) {
        $sql = "INSERT INTO students (full_name, email, sr_code, mobile_number, password, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$full_name, $email, $sr_code, $mobile_number, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }

    public function updateUser($id, $full_name, $email, $sr_code, $mobile_number) {
        $sql = "UPDATE students SET full_name = ?, email = ?, sr_code = ?, mobile_number = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$full_name, $email, $sr_code, $mobile_number, $id]);
    }
}

$handler = new UserAccountHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $handler->addUser($_POST['full_name'], $_POST['email'], $_POST['sr_code'], $_POST['mobile_number'], $_POST['password']);
                break;
            case 'delete':
                $handler->deleteUser($_POST['id']);
                break;
            case 'update':
                $handler->updateUser($_POST['id'], $_POST['full_name'], $_POST['email'], $_POST['sr_code'], $_POST['mobile_number']);
                break;
        }
    }
    header("Location: useraccount.php");
    exit();
}

$users = $handler->fetchAllUsers();
?>
