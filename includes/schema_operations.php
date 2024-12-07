<?php
require_once '../classes/schema_handler.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle all requests
header('Content-Type: application/json');
$schema = new Schema();

try {
    $action = $_REQUEST['action'] ?? '';
    
    switch ($action) {
        case 'get':
            if (!isset($_GET['id'])) {
                throw new Exception('No ID provided');
            }
            $result = $schema->getSchemaById($_GET['id']);
            echo json_encode($result);
            break;

        case 'delete':
            if (!isset($_POST['id'])) {
                throw new Exception('No ID provided');
            }
            $result = $schema->deleteSchema($_POST['id']);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Schema deleted successfully' : 'Failed to delete schema'
            ]);
            break;

        case 'edit':
            if (!isset($_POST['schema_id'])) {
                throw new Exception('No schema ID provided');
            }
            $result = $schema->updateSchema($_POST);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Schema updated successfully' : 'Failed to update schema'
            ]);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    error_log("Schema Operation Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 