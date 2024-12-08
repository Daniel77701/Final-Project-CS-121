<?php
session_start();
require_once "FAQ'S_handler.php";

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add':
                $question = trim($_POST['question']);
                $answer = trim($_POST['answer']);
                
                if (!empty($question) && !empty($answer)) {
                    if ($faq->addFAQ($question, $answer)) {
                        echo json_encode(['success' => true, 'message' => 'FAQ added successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to add FAQ']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Question and answer are required']);
                }
                break;

            case 'edit':
                $id = $_POST['id'];
                $question = trim($_POST['question']);
                $answer = trim($_POST['answer']);
                
                if (!empty($id) && !empty($question) && !empty($answer)) {
                    if ($faq->updateFAQ($id, $question, $answer)) {
                        echo json_encode(['success' => true, 'message' => 'FAQ updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update FAQ']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'All fields are required']);
                }
                break;

            case 'delete':
                $id = $_POST['id'];
                
                if (!empty($id)) {
                    if ($faq->deleteFAQ($id)) {
                        echo json_encode(['success' => true, 'message' => 'FAQ deleted successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to delete FAQ']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'FAQ ID is required']);
                }
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 