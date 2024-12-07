<?php
include 'config.php';

try {
    if (!$conn) {
        throw new Exception("Database connection not established");
    }

    // Debug: First, let's see what columns we have
    $query = "SELECT COLUMN_NAME 
              FROM INFORMATION_SCHEMA.COLUMNS 
              WHERE TABLE_NAME = 'scholarship_request'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    error_log("Table columns: " . print_r($stmt->fetchAll(PDO::FETCH_COLUMN), true));

    // Now get the actual data
    $query = "SELECT * FROM scholarship_request";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $requests = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        error_log("Row data: " . print_r($row, true));
        $requests[] = $row;
    }
    
    echo json_encode(['success' => true, 'requests' => $requests]);
} catch(Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn = null;
?> 