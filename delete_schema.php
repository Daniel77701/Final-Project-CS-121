<?php
require_once 'config.php';
require_once 'dbh.classes.php';

try {
    if (!isset($_POST['id'])) {
        throw new Exception('No schema ID provided');
    }

    $db = new Dbh();
    $conn = $db->connect();

    $stmt = $conn->prepare("DELETE FROM scholarship_schema WHERE schema_id = :id");
    $stmt->execute(['id' => $_POST['id']]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Schema not found']);
    }

} catch (Exception $e) {
    error_log("Error in delete_schema.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 