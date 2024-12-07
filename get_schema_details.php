<?php
require_once 'config.php';
require_once 'dbh.classes.php';

try {
    if (!isset($_GET['id'])) {
        throw new Exception('No schema ID provided');
    }

    $db = new Dbh();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM scholarship_schema WHERE schema_id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    
    $schema = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($schema) {
        echo json_encode($schema);
    } else {
        echo json_encode(['error' => 'Schema not found']);
    }

} catch (Exception $e) {
    error_log("Error in get_schema_details.php: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
?> 