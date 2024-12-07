<?php
require_once '../classes/schema_handler.php';

header('Content-Type: application/json');

try {
    $schema = new Schema();
    $count = $schema->getActiveSchemaCount();
    
    echo json_encode([
        'success' => true,
        'count' => $count
    ]);
} catch (Exception $e) {
    error_log("Error getting schema count: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Failed to get schema count'
    ]);
} 