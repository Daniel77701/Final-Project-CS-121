<?php
session_start();
require_once '../classes/settings_handler.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Debug log
        error_log('Received POST data: ' . print_r($_POST, true));

        // Get and validate data
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $schoolYear = isset($_POST['schoolYear']) ? trim($_POST['schoolYear']) : '';
        $semester = isset($_POST['semester']) ? trim($_POST['semester']) : '';

        // Debug log
        error_log("Processing update - ID: $id, School Year: $schoolYear, Semester: $semester");

        // Validate data
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid ID');
        }

        if (empty($schoolYear)) {
            throw new Exception('School Year is required');
        }

        if (empty($semester)) {
            throw new Exception('Semester is required');
        }

        $settingHandler = new SettingHandler();
        $result = $settingHandler->updateSetting($id, $schoolYear, $semester);

        if ($result) {
            echo json_encode([
                'success' => true, 
                'message' => 'Setting updated successfully',
                'data' => [
                    'id' => $id,
                    'schoolYear' => $schoolYear,
                    'semester' => $semester
                ]
            ]);
        } else {
            throw new Exception('Failed to update setting');
        }
    } else {
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    error_log('Error in settings_update.php: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'debug' => [
            'post_data' => $_POST,
            'error' => $e->getMessage()
        ]
    ]);
} 