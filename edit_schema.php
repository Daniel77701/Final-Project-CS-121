<?php
require_once 'config.php';
require_once 'dbh.classes.php';

// Add debugging
error_log("POST data received: " . print_r($_POST, true));

try {
    $db = new Dbh();
    $conn = $db->connect();

    // Get and sanitize form data
    $schemaId = $_POST['schema_id'] ?? '';
    $scholarshipType = $_POST['scholarshipType'] ?? '';
    $gradeCampus = $_POST['gradeCampus'] ?? '';
    $yearScholarship = $_POST['yearScholarship'] ?? '';
    $category = $_POST['category'] ?? '';
    $submissionDeadline = $_POST['submissionDeadline'] ?? '';
    $amountPerSem = $_POST['amountPerSem'] ?? '';
    $criteria = $_POST['criteria'] ?? '';
    $requiredDocuments = $_POST['requiredDocuments'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? '';

    // Debug the values
    error_log("Processed values:");
    error_log("Schema ID: " . $schemaId);
    error_log("Scholarship Type: " . $scholarshipType);

    // Validate required fields
    if (empty($schemaId)) {
        throw new Exception('Schema ID is required');
    }

    $sql = "UPDATE scholarship_schema SET 
        scholarship_type = :scholarshipType,
        grade_campus = :gradeCampus,
        year_scholarship = :yearScholarship,
        category = :category,
        submission_deadline = :submissionDeadline,
        amount_per_sem = :amountPerSem,
        criteria = :criteria,
        required_documents = :requiredDocuments,
        description = :description,
        status = :status
        WHERE schema_id = :schemaId";

    // Debug the SQL and parameters
    error_log("SQL Query: " . $sql);
    
    $stmt = $conn->prepare($sql);
    $params = [
        ':schemaId' => $schemaId,
        ':scholarshipType' => $scholarshipType,
        ':gradeCampus' => $gradeCampus,
        ':yearScholarship' => $yearScholarship,
        ':category' => $category,
        ':submissionDeadline' => $submissionDeadline,
        ':amountPerSem' => $amountPerSem,
        ':criteria' => $criteria,
        ':requiredDocuments' => $requiredDocuments,
        ':description' => $description,
        ':status' => $status
    ];
    
    error_log("Parameters: " . print_r($params, true));
    
    $result = $stmt->execute($params);

    if ($result) {
        error_log("Update successful");
        echo json_encode(['success' => true, 'message' => 'Schema updated successfully']);
    } else {
        error_log("Update failed");
        error_log("PDO Error Info: " . print_r($stmt->errorInfo(), true));
        echo json_encode(['success' => false, 'message' => 'Failed to update schema']);
    }

} catch (Exception $e) {
    error_log("Error in edit_schema.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 