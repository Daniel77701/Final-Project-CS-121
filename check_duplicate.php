<?php
require_once "classes/dbh.classes.php";

$conn = new mysqli("localhost", "root", "", "db_scholarshiptracker");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$field = $_POST['field'];
$value = $_POST['value'];

// Validate field name to prevent SQL injection
$allowed_fields = ['email', 'sr_code'];
if (!in_array($field, $allowed_fields)) {
    die(json_encode(['exists' => false]));
}

$sql = "SELECT COUNT(*) as count FROM users_account WHERE $field = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $value);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count'];

echo json_encode(['exists' => $count > 0]);

$conn->close();
?> 