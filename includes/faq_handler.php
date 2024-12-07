<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../classes/FAQ'S_handler.php";

header('Content-Type: application/json');

try {
    $faq = new FAQ();
    $response = ['success' => false, 'message' => 'Invalid request'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add':
                $question = trim($_POST['question'] ?? '');
                $answer = trim($_POST['answer'] ?? '');
                $response = $faq->addFAQ($question, $answer);
                break;

            case 'edit':
                $id = $_POST['id'] ?? '';
                $question = trim($_POST['question'] ?? '');
                $answer = trim($_POST['answer'] ?? '');
                $response = $faq->updateFAQ($id, $question, $answer);
                break;

            case 'delete':
                $id = $_POST['id'] ?? '';
                $response = $faq->deleteFAQ($id);
                break;

            default:
                $response = ['success' => false, 'message' => 'Invalid action'];
        }
    }

    echo json_encode($response);
} catch (Exception $e) {
    error_log("FAQ Handler Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error occurred']);
}
