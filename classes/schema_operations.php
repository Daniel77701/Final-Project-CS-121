<?php
require_once '../connection/dbh.classes.php';

class SchemaOperations extends Dbh {
    public function getSchemaById($id) {
        try {
            $stmt = $this->connect()->prepare("SELECT schema_id, scholarship_type, grade_campus, 
                year_scholarship, category, criteria, submission_deadline, required_documents, 
                description, amount_per_sem, status, published_date 
                FROM scholarship_schema WHERE schema_id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                return ['error' => 'Schema not found'];
            }
            
            // Format dates and numbers for display
            if ($result['submission_deadline']) {
                $result['submission_deadline'] = date('Y-m-d', strtotime($result['submission_deadline']));
            }
            if ($result['amount_per_sem']) {
                $result['amount_per_sem'] = number_format($result['amount_per_sem'], 2, '.', '');
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error getting schema details: " . $e->getMessage());
            return ['error' => 'Database error occurred'];
        }
    }

    public function deleteSchema($id) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM scholarship_schema WHERE schema_id = ?");
            $success = $stmt->execute([$id]);
            
            if (!$success) {
                error_log("Delete failed for ID: " . $id . ". Error: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting schema: " . $e->getMessage());
            return false;
        }
    }

    public function updateSchema($data) {
        try {
            $sql = "UPDATE scholarship_schema SET 
                scholarship_type = ?,
                grade_campus = ?,
                year_scholarship = ?,
                category = ?,
                criteria = ?,
                submission_deadline = ?,
                required_documents = ?,
                description = ?,
                amount_per_sem = ?,
                status = ?,
                published_date = CURDATE()
                WHERE schema_id = ?";

            $stmt = $this->connect()->prepare($sql);
            return $stmt->execute([
                $data['scholarshipType'],
                $data['gradeCampus'],
                $data['yearScholarship'],
                $data['category'],
                $data['criteria'],
                $data['submissionDeadline'],
                $data['requiredDocuments'],
                $data['description'],
                $data['amountPerSem'],
                $data['status'] ?? 'Open',
                $data['schema_id']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating schema: " . $e->getMessage());
            return false;
        }
    }

    // ... other methods remain the same ...
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle all requests
header('Content-Type: application/json'); // Ensure JSON response
$schemaOps = new SchemaOperations();
$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {
        case 'get':
            if (!isset($_GET['id'])) {
                throw new Exception('No ID provided');
            }
            error_log("Fetching schema ID: " . $_GET['id']);
            $result = $schemaOps->getSchemaById($_GET['id']);
            error_log("Result: " . print_r($result, true));
            echo json_encode($result);
            break;

        case 'delete':
            if (!isset($_POST['id'])) {
                throw new Exception('No ID provided');
            }
            error_log("Attempting to delete schema ID: " . $_POST['id']);
            $result = $schemaOps->deleteSchema($_POST['id']);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Schema deleted successfully' : 'Failed to delete schema'
            ]);
            break;

        case 'edit':
            if (!isset($_POST['schema_id'])) {
                throw new Exception('No schema ID provided');
            }
            $result = $schemaOps->updateSchema($_POST);
            if ($result) {
                header('Location: ../schema.php?success=updated');
            } else {
                header('Location: ../schema.php?error=update_failed');
            }
            exit();
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage()
    ]);
} 